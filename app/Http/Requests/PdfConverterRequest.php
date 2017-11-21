<?php
/**
 * User: sanjib
 * Date: 21/11/17
 * Time: 5:10 PM
 */

namespace App\Http\Requests;

/**
 * Class PdfConverterRequest
 *
 * @package App\Http\Requests
 */
class PdfConverterRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file'      => 'mimetypes:text/plain,text/html,application/pdf',
            'link'      => 'url',
            'file_name' => 'string',
        ];
    }
}
