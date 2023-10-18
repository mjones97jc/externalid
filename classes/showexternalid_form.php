<?php
require_once("$CFG->libdir/formslib.php");

class showexternalid_form extends moodleform
{
    function definition()
    {
        global $CFG, $COURSE;

        $mform =& $this->_form;

        $mform->addElement("hidden", "id", $COURSE->id);
        $mform->setType('id', PARAM_RAW);
        $mform->addElement("hidden", "showexternalid", 1);
        $mform->setType('showexternalid', PARAM_INT);
        $mform->addElement('submit', 'show', get_string('showexternalid', 'block_externalid'), 2);
    }
}