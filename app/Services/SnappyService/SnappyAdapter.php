<?php
/**
 * User: sanjib
 * Date: 26/9/17
 * Time: 3:32 PM
 */

namespace App\Services\SnappyService;

use Barryvdh\Snappy\PdfWrapper;
use App\Contracts\ConverterAdapterRepository;

/**
 * Class SnappyAdapter
 *
 * @package App\Services\SnappyService
 * @mixin PdfWrapper
 * @inheritdoc
 */
class SnappyAdapter implements ConverterAdapterRepository
{
    /**
     * @var PdfWrapper
     */
    private $snappy;

    /**
     * SnappyAdapter constructor.
     *
     * @param PdfWrapper $snappy
     */
    public function __construct(PdfWrapper $snappy)
    {
        $this->snappy = $snappy;
    }

    /**
     * @param       $name
     * @param array $arguments
     *
     * @return PdfWrapper
     */
    public function __call($name, array $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array(array($this, $name), $arguments);
        }

        return call_user_func_array(array($this->snappy, $name), $arguments);
    }

    /**
     * Load the content in memory from string content.
     *
     * @param string $content
     *
     * @return mixed
     */
    public function loadFromString($content)
    {
        $this->snappy->loadHTML($content);

        return $this;
    }

    /**
     * Load the content in memory from a link which points to a webpage.
     *
     * @param string $link
     *
     * @return SnappyAdapter
     */
    public function loadFromLink($link)
    {
        $this->snappy->loadFile($link);

        return $this;
    }

    /**
     * Set paper type default a4.
     *
     * @param string $paperType
     *
     * @return SnappyAdapter
     */
    public function setPaper($paperType = 'a4')
    {
        $this->snappy->setPaper($paperType);

        return $this;
    }

    /**
     * Save the content which is loaded in the memory.
     *
     * @param string $path
     * @param bool   $ovewrite
     *
     * @return SnappyAdapter
     */
    public function save($path, $ovewrite = false)
    {
        $this->snappy->save($path, $ovewrite);

        return $this;
    }

    /**
     * Return a response with the PDF to show in the browser
     *
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function inline($fileName)
    {
        return $this->snappy->inline($fileName);
    }
}
