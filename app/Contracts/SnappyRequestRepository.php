<?php
/**
 * User: sanjib
 * Date: 26/9/17
 * Time: 3:30 PM
 */

namespace App\Contracts;

use Illuminate\Http\Request;

/**
 * Interface SnappyRequestRepository
 *
 * @package SWX\Repositories
 */
interface SnappyRequestRepository
{
    /**
     * Set the request object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request);

    /**
     * Set the data for snappy.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile|string $resource
     * @param string              $type This can be raw,file,link
     * @param string|null         $fileName
     * @param bool                $base64Encoded
     *
     * @return $this
     */
    public function setData($resource, $type, $fileName = null, $base64Encoded = false);

    /**
     * Set the file name for the output.
     *
     * @param string $fileName
     *
     * @return $this
     */
    public function setFileName($fileName);

    /**
     * Get the file name for the output.
     *
     * @return string
     */
    public function getFileName();

    /**
     * Get the resource.
     *
     * @return string|\Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getResource();

    /**
     * Get type of the resource.
     *
     * @return string
     */
    public function getType();

    /**
     * Check if the raw data is encoded.
     *
     * @return bool
     */
    public function isRawEncoded();

    /**
     * Check if the resource is a file.
     *
     * @return bool
     */
    public function isFile();

    /**
     * Check if the resource is a link.
     *
     * @return bool
     */
    public function isLink();

    /**
     * Check if the resource is a raw string.
     *
     * @return bool
     */
    public function isRaw();
}
