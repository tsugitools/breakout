<?php
require_once "../config.php";
include 'src/Template.php';

use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;
use \Tsugi\UI\SettingsForm;

// The Tsugi PHP API Documentation is available at:
// http://do1.dr-chuck.com/tsugi/phpdoc/

// No parameter means we require CONTEXT, USER, and LINK
$LAUNCH = LTIX::requireData();

// Handle the incoming post first
if ( $LAUNCH->link && $LAUNCH->link->id && SettingsForm::handleSettingsPost() ) {
    header('Location: '.addSession('index.php') ) ;
    return;
}

// Handle Post Data
$p = $CFG->dbprefix;

$menu = false;
// if ( $LAUNCH->user->instructor ) {
//     $menu = new \Tsugi\UI\MenuSet();
//     if ( $CFG->launchactivity ) {
//         $menu->addRight(__('Analytics'), 'analytics');
//     }
//     $menu->addRight(__('Settings'), '#', /* push */ false, SettingsForm::attr());
// }

$context = [
    'context_id' => $CONTEXT->id,
    'context_key' => $CONTEXT->key,
    'instructor' => $USER->instructor,
    'name' => $USER->firstname
];

// echo '<pre>' . var_export($context, true) . '</pre>';

// Render view
$OUTPUT->header();
Template::view('templates/header.html', $context);

$OUTPUT->bodyStart();
$OUTPUT->topNav($menu);
$OUTPUT->flashMessages();

$OUTPUT->welcomeUserCourse();

Template::view('templates/body.html', $context);

$OUTPUT->footerStart();

Template::view('templates/footer.html', $context);
$OUTPUT->footerEnd();

?>
