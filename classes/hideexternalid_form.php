<?php
require_once("$CFG->libdir/formslib.php");

class hideexternalid_form extends moodleform
{
    function definition()
    {
        global $CFG, $COURSE;

        $mform =& $this->_form;

        $mform->addElement("hidden", "id", $COURSE->id);
        $mform->setType('id', PARAM_RAW);
        $mform->addElement("hidden", "hideexternalid", 1);
        $mform->setType('hideexternalid', PARAM_INT);
        $mform->addElement('submit', 'hide', get_string('hideexternalid', 'block_externalid'), 2);
    }
}