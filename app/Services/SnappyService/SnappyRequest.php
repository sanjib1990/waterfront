<?php
/**
 * User: sanjib
 * Date: 26/9/17
 * Time: 3:32 PM
 */

namespace App\Services\SnappyService;

use Illuminate\Http\Request;
use App\Exceptions\HttpHeaderException;
use App\Contracts\SnappyRequestRepository;
use App\Exceptions\InvalidUserInputException;
use App\Exceptions\HeaderNotSupportedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class SnappyRequest
 *
 * @package App\Services\SnappyService
 */
class SnappyRequest implements SnappyRequestRepository
{
    /**
     * @var UploadedFile|string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $rawEncoded;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Set the request object.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request  = $request;

        $this->setRequestData()->setFileName($request->get('file_name'));

        return $this;
    }

    /**
     * Set the data for snappy.
     *
     * @param UploadedFile|string $resource
     * @param string              $type This can be raw,file,link
     * @param string|null         $fileName
     * @param bool                $base64Encoded
     *
     * @return $this
     */
    public function setData($resource, $type, $fileName = null, $base64Encoded = false)
    {
        $this
            ->setResource($resource)
            ->setType($type)
            ->setFileName($fileName)
            ->setRawEncoding($base64Encoded);

        return $this;
    }

    /**
     * Set the file name for the output.
     *
     * @param string $fileName
     *
     * @return $this
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the file name for the output.
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Get the resource.
     *
     * @return string|UploadedFile
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Get type of the resource.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Check if the raw data is encoded.
     *
     * @return bool
     */
    public function isRawEncoded()
    {
        return $this->rawEncoded;
    }

    /**
     * Check if the resource is a file.
     *
     * @return bool
     */
    public function isFile()
    {
        return $this->type === 'file';
    }

    /**
     * Check if the resource is a link.
     *
     * @return bool
     */
    public function isLink()
    {
        return $this->type === 'link';
    }

    /**
     * Check if the resource is a raw string.
     *
     * @return bool
     */
    public function isRaw()
    {
        return $this->type === 'raw';
    }

    /**
     * Set request data for conversion.
     *
     * @return $this
     * @throws InvalidUserInputException
     */
    private function setRequestData()
    {
        $params = $this->request->only(['file', 'link']);

        if (empty($params['file']) && empty($params['link']) && empty($this->request->getContent())) {
            throw new InvalidUserInputException("No input supplied.");
        }

        if (empty($params['file']) && empty($params['link'])) {
            return $this->setRawData();
        }

        return !empty($params['file'])
            ? $this->setResource($params['file'])->setType('file')
            : $this->setResource($params['link'])->setType('link');
    }

    /**
     * Get the raw data for conversion.
     *
     * @return $this
     * @throws HeaderNotSupportedException
     * @throws HttpHeaderException
     */
    private function setRawData()
    {
        if (! $this->request->header('X-CONTENT-TYPE')) {
            throw new HttpHeaderException();
        }

        $this->setType('raw');

        switch ($this->request->header('X-CONTENT-TYPE')) {
            case 'application/pdf':
                return $this->setResource($this->request->getContent());
            case 'application/base64encoded-pdf':
                return $this->setResource(base64_decode($this->request->getContent()))->setRawEncoding(true);
            default:
                throw new HeaderNotSupportedException();
        }
    }

    /**
     * Set the resource, which can be an instance of Uploadfile, raw content, link
     *
     * @param UploadedFile|string $resource
     *
     * @return $this
     */
    private function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Set type of the resource.
     *
     * @param $type
     *
     * @return $this
     */
    private function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the raw data encoding.
     *
     * @param boolean $base64Encoded
     *
     * @return $this
     */
    private function setRawEncoding($base64Encoded)
    {
        $this->rawEncoded   = $base64Encoded;

        return $this;
    }
}
