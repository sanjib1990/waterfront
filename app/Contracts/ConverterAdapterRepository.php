<?php
/**
 * User: sanjib
 * Date: 21/11/17
 * Time: 5:04 PM
 */

namespace App\Contracts;

/**
 * Interface ConverterAdapterRepository
 *
 * @package App\Contracts
 */
interface ConverterAdapterRepository
{
    /**
     * Load the content in memory from string content.
     *
     * @param string $content
     *
     * @return ConverterAdapterRepository
     */
    public function loadFromString($content);

    /**
     * Load the content in memory from a link which points to a webpage.
     *
     * @param string $link
     *
     * @return ConverterAdapterRepository
     */
    public function loadFromLink($link);

    /**
     * Set paper type default a4.
     *
     * @param string $paperType
     *
     * @return ConverterAdapterRepository
     */
    public function setPaper($paperType = 'a4');

    /**
     * Save the content which is loaded in the memory.
     *
     * @param string $path
     * @param bool   $ovewrite
     *
     * @return ConverterAdapterRepository
     */
    public function save($path, $ovewrite);

    /**
     * Return a response with the PDF to show in the browser
     *
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function inline($fileName);
}
