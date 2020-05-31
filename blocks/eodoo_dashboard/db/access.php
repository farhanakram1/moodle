<?php

/**
 * Eodo Dashboard block caps.
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = array(
 
            'block/eodoo_dashboard:myaddinstance' => array(
                'captype' => 'write',
                'contextlevel' => CONTEXT_SYSTEM,
                'archetypes' => array(
                    'user' => CAP_PROHIBIT
                ),
         
                'clonepermissionsfrom' => 'moodle/my:manageblocks'
            ),
         
            'block/eodoo_dashboard:addinstance' => array(
                'riskbitmask' => RISK_SPAM | RISK_XSS,
         
                'captype' => 'write',
                'contextlevel' => CONTEXT_SYSTEM,
                'archetypes' => array(
                    'editingteacher' => CAP_PROHIBIT,
                    'manager' => CAP_PROHIBIT
                ),
         
                'clonepermissionsfrom' => 'moodle/site:manageblocks'
            ),
);