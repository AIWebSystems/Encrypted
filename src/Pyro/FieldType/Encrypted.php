<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * Streams Encrypted Field Type
 *
 * @package        PyroCMS\Addons\Shared Addons\Field Types
 */
class Encrypted extends FieldTypeAbstract
{
    public $field_type_slug = 'encrypted';

    public $db_col_type = 'text';

    public $version = '1.0';

    /**
     * Custom options
     * @var array
     */
    public $custom_parameters = array(
        'hide_typing',
        );
    
    /**
     * About meh
     * @var array
     */
    public $author = array(
        'name' => 'AI Web Systems, Inc. - Ryan Thompson',
        'url' => 'http://www.aiwebsystems.com/'
        );

    ///////////////////////////////////////////////////////////////////////////////
    // --------------------------    METHODS       ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Construct
     */
    public function __construct()
    {
        ci()->load->library('encrypt');
    }

    /**
     * Output form input
     *
     * @access     public
     * @return    string
     */
    public function formInput()
    {
        return form_input($this->form_slug, $this->value, 'class="form-control" placeholder="'.$this->getParameter('placeholder', '****************').'"');
    }

    /**
     * Output filter input
     *
     * @access     public
     * @return    string
     */
    public function filterInput()
    {
        return 'No filter available';
    }

    /**
     * Process before saving
     * @return string
     */
    public function preSave()
    {
        // Encrypt the value if any and not our placeholder
        if ($this->value) {
            return ci()->encrypt->encode($this->value);
        }

        return null;
    }

    /**
     * Pre Ouput
     *
     * Process before outputting on the CP. Since
     * there is less need for performance on the back end,
     * this is accomplished via just grabbing the title column
     * and the id and displaying a link (ie, no joins here).
     *
     * @return    mixed     null or string
     */
    public function stringOutput()
    {
        return '********';
    }

    ///////////////////////////////////////////////////////////////////////////////
    // -------------------------    PARAMETERS       ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////////
    // -----------------------------    AJAX       ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////////
    // -------------------------    UTILITIES       ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Return the decoded output
     * @return string
     */
    public function decodedOutput()
    {
        if ($this->value)
            return ci()->encrypt->decode($this->value);
        else
            return null;
    }
}
