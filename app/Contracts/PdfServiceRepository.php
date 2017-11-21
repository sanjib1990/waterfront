<?php
/**
 * User: sanjib
 * Date: 26/9/17
 * Time: 3:29 PM
 */

namespace App\Contracts;

/**
 * Interface PdfServiceRepository
 *
 * @package SWX\Repositories
 */
interface PdfServiceRepository
{
    /**
     * Set the request instance.
     *
     * @param SnappyRequestRepository $request
     *
     * @return PdfServiceRepository
     */
    public function setRequest(SnappyRequestRepository $request);

    /**
     * Set the disk where the converted pdf will reside.
     *
     * @param string|null $disk
     *
     * @return PdfServiceRepository
     */
    public function setConvertDisk($disk = null);

    /**
     * Set the disk where the pdf will be uploaded.
     *
     * @param string|null $disk
     *
     * @return PdfServiceRepository
     */
    public function setUploadDisk($disk = null);

    /**
     * Convert a resource to pdf.
     *
     * @return string
     */
    public function convert();

    /**
     * Upload the converted pdf.
     *
     * @param string $uploadPath
     *
     * @return string
     */
    public function upload($uploadPath);

    /**
     * Convert a resource to pdf and upload.
     *
     * @return string
     */
    public function convertAndUpload();

    /**
     * Convert the resource to pdf and stream the output.
     *
     * @return mixed
     */
    public function convertAndStream();

    /**
     * Get the stream of a pdf which was converted previously.
     *
     * @param $path
     *
     * @return mixed
     */
    public function getStream($path);
}
