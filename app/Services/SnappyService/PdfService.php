<?php
/**
 * User: sanjib
 * Date: 26/9/17
 * Time: 3:31 PM
 */

namespace App\Services\SnappyService;

use App\Exceptions\PdfUploadException;
use App\Exceptions\ConvertionException;
use App\Contracts\PdfServiceRepository;
use App\Contracts\SnappyRequestRepository;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PdfService
 *
 * @package App\Services\SnappyService
 */
class PdfService implements PdfServiceRepository
{
    /**
     * Decide whether or not to stream the converted pdf.
     *
     * @var boolean
     */
    protected $shouldStream = false;

    /**
     * @var SnappyAdapter
     */
    private $snappy;

    /**
     * @var FilesystemManager
     */
    private $storage;

    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $convertDisk;

    /**
     * @var string
     */
    private $uploadDisk;

    /**
     * @var string
     */
    private $convertedFilePath;

    /**
     * @var SnappyRequest
     */
    private $request;

    /**
     * PdfService constructor.
     *
     * @param SnappyAdapter     $snappy
     * @param FilesystemManager $storage
     */
    public function __construct(SnappyAdapter $snappy, FilesystemManager $storage)
    {
        $this->snappy   = $snappy;
        $this->storage  = $storage;

        // initialize the member variables
        $this->setConvertDisk()->setUploadDisk();
    }

    /**
     * Set the request instance.
     *
     * @param SnappyRequestRepository $request
     *
     * @return PdfService
     */
    public function setRequest(SnappyRequestRepository $request)
    {
        $this->request  = $request;

        return $this;
    }

    /**
     * Set the disk where the converted pdf will reside.
     *
     * @param string|null $disk
     *
     * @return PdfService
     */
    public function setConvertDisk($disk = null)
    {
        $this->convertDisk  = $disk ?: $this->getFromConfig('convert_disk');

        return $this;
    }

    /**
     * Set the disk where the pdf will be uploaded.
     *
     * @param string|null $disk
     *
     * @return PdfService
     */
    public function setUploadDisk($disk = null)
    {
        $this->uploadDisk   = $disk ?: $this->getFromConfig('upload_disk');

        return $this;
    }

    /**
     * Convert the resource to PDF.
     *
     * @return string
     */
    public function convert()
    {
        $this->convertedFilePath = $this->getConvertedFilePath();

        return $this->process();
    }

    /**
     * Convert the resource to pdf and stream the output.
     *
     * @return mixed
     */
    public function convertAndStream()
    {
        $this->convertedFilePath = $this->getConvertedFilePath();

        $this->shouldStream = true;

        return $this->process();
    }

    /**
     * Upload the converted pdf.
     *
     * @param string|null $uploadPath
     * @param string|null $filePath
     *
     * @return string
     * @throws \Exception
     */
    public function upload($uploadPath = null, $filePath = null)
    {
        $filePath   = $filePath ?: $this->convertedFilePath;
        $uploadPath = $uploadPath ?: str_random().'.pdf';

        if (empty($filePath)) {
            throw new \Exception("File path not found.");
        }

        try {
            $this
                ->storage
                ->disk($this->uploadDisk)
                ->put($uploadPath, file_get_contents($filePath));
        } catch (\Exception $exception) {
            // Delete the locally stored file and throw exception.
            unlink($filePath);
            \Log::error("[UPLOAD EXCEPTION]", [$exception]);
            throw new PdfUploadException();
        }

        // Delete the locally stored file.
        unlink($filePath);

        return $uploadPath;
    }

    /**
     * Convert to pdf and upload.
     *
     * @param string|null $uploadPath
     *
     * @return string
     */
    public function convertAndUpload($uploadPath = null)
    {
        $filePath = $this->convert();

        $uploadPath = $uploadPath ?: $this->request->getFileName();

        return $this->upload($uploadPath, $filePath);
    }

    /**
     * Get the stream of a pdf which was converted previously.
     *
     * @param $path
     *
     * @return mixed
     */
    public function getStream($path)
    {
        return $this
            ->storage
            ->disk($this->uploadDisk)
            ->get($path);
    }

    /**
     * Process the data.
     *
     * @return string
     */
    protected function process()
    {
        /**
         * If the file is a pdf, return the temp file path.
         */
        if ($this->request->isFile() && $this->request->getResource()->getMimeType() == 'application/pdf') {
            return $this->shouldStream ? $this->stream() : $this->request->getResource()->getRealPath();
        }

        /**
         * for other file type convert them to pdf and return the path.
         */
        if ($this->request->isFile()) {
            return $this->save('file');
        }

        /**
         * Handle pdf raw stream content to pdf
         */
        if ($this->request->isRaw()) {
            return $this->handleRaw();
        }

        /**
         * for link render the link in memory and convert the page to pdf
         * and return the path of the saved pdf file.
         */
        return $this->save('link');
    }

    /**
     * Handle the raw content.
     *
     * @return string
     */
    protected function handleRaw()
    {
        if ($this->shouldStream) {
            $fileName   = $this->request->getFileName() ?: str_random().'.pdf';

            return new Response($this->request->getResource(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$fileName.'"'
            ]);
        }

        file_put_contents($this->convertedFilePath, $this->request->getResource());

        return $this->convertedFilePath;
    }

    /**
     * Convert to pdf and return the path.
     *
     * @param string $type
     *
     * @return string
     * @throws ConvertionException
     */
    private function save($type)
    {
        try {
            $snappy = $this
                ->getWrapperInstance($type)
                ->setPaper('a4');

            if ($this->shouldStream) {
                $fileName   = $this->request->getFileName() ?: str_random().'.pdf';

                return $snappy->inline($fileName);
            }

            $snappy->save($this->convertedFilePath, true);
        } catch (\Exception $exception) {
            \Log::error("[CONVERSION ERROR]", [$exception]);
            throw new ConvertionException();
        }

        return $this->convertedFilePath;
    }

    /**
     * @param string $type
     *
     * @return SnappyAdapter
     */
    private function getWrapperInstance($type)
    {
        $resource   = $this->request->getResource();

        if ($type == 'file') {
            return $this->snappy->loadFromString(file_get_contents($resource));
        }

        return $this->snappy->loadFromLink($resource);
    }

    /**
     * Get from the file system config.
     *
     * @param string $key
     *
     * @return mixed
     */
    private function getFromConfig($key)
    {
        if (empty($this->config)) {
            $this->config   = config('filesystems');
        }

        return array_get($this->config, $key);
    }

    /**
     * Get the full os path where the converted file will reside.
     *
     * @return string
     */
    private function getConvertedFilePath()
    {
        return $this->getFromConfig('disks.'.$this->convertDisk.'.root').'/'.str_random().'.pdf';
    }

    /**
     * Stream converted pdf file.
     *
     * @return mixed
     */
    private function stream()
    {
        $fileName   = $this->request->getFileName() ?: str_random().'.pdf';

        return $this
            ->snappy
            ->loadFromString(file_get_contents($this->request->getResource()->getRealPath()))
            ->setPaper('a4')
            ->inline($fileName);
    }
}
