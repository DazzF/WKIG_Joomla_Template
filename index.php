<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option = $app->input->getCmd('option', '');
$view = $app->input->getCmd('view', '');
$layout = $app->input->getCmd('layout', '');
$task = $app->input->getCmd('task', '');
$itemid = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if ($task == "edit" || $layout == "form") {
    $fullWidth = 1;
} else {
    $fullWidth = 0;
}

// Add Stylesheets
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/bootstrap.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/font-awesome.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css');
if($this->params->get('customcss')) {
    $doc->addStyleSheet($this->baseurl . htmlspecialchars($this->params->get('customcss'), ENT_COMPAT, 'UTF-8'));
} 

// Add scripts
JHtml::_('jquery.framework');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/popper.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/bootstrap.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/template.js');

// Adjusting content width
if ($this->countModules('sidebar-left') && $this->countModules('sidebar-right')) {
    $span = "col-md-6";
} elseif ($this->countModules('sidebar-left') && !$this->countModules('sidebar-right')) {
    $span = "col-md-9";
} elseif (!$this->countModules('sidebar-left') && $this->countModules('sidebar-right')) {
    $span = "col-md-9";
} else {
    $span = "col-md-12";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <jdoc:include type="head" />
        <?php if($this->params->get('favicon')) { ?>
            <link rel="shortcut icon" href="<?php echo JUri::root(true) . htmlspecialchars($this->params->get('favicon'), ENT_COMPAT, 'UTF-8'); ?>" />
        <?php } ?>
        <!--[if lt IE 9]>
                <script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <header class="navbar navbar-expand-lg navbar-dark bg-primary">
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
            </button>
            <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <a href="#">
                         <img src="<?php echo JURI::base(); ?>/images/aa-logo-200x200-white-130x130.png"  title="" style="height: 3.8rem;">
                    </a>
                </span>
                
            </div>
        </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <jdoc:include type="modules" name="navbar-1" style="none" />
                <jdoc:include type="modules" name="navbar-2" style="none" />
            </div>
        </header>
        <div class="body">
            <div class="content">
            <div class="row" style="height: 20px;"></div>
                <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                    <jdoc:include type="modules" name="banner" style="xhtml" />
                    <?php if ($this->countModules('breadcrumbs')) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <jdoc:include type="modules" name="breadcrumbs" style="xhtml" />
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                    <?php if ($this->countModules('sidebar-left')) { ?>
                        <?php $sidebarleftcol="col-md-3"; $maincol="col-md-8"; $sidebarrightcol="col-md-1"; ?>
                    <?php } else { ?>
                    <?php $sidebarleftcol="col-md-2"; $maincol="col-md-8"; $sidebarrightcol="col-md-2"; ?>
                    <?php } ?>
                        <div id="sidebar" class="<?php echo $sidebarleftcol; ?>">
                            <div class="sidebar-nav">
                                <?php if ($this->countModules('sidebar-left')) : ?>
                                    <jdoc:include type="modules" name="sidebar-left" style="xhtml" />
                                <?php endif; ?>
                            </div>
                        </div>
                        <main id="content" role="main" class="<?php echo $maincol; ?> <?php echo $span; ?>">
                            <jdoc:include type="modules" name="position-3" style="xhtml" />
                            <jdoc:include type="message" />
                            <jdoc:include type="component" />
                            <jdoc:include type="modules" name="position-2" style="none" />
                        </main>
                        <div id="aside" class="<?php echo $sidebarrightcol; ?>">
                            <?php if ($this->countModules('sidebar-right')) : ?>
                                <jdoc:include type="modules" name="sidebar-right" style="xhtml" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer bg-faded text-muted" role="contentinfo">
            <hr />
            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-sm-12 text-center"><p>
                            &copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
                        </p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <jdoc:include type="modules" name="footer" style="none" />
                        <p></p>
                    </div>
                    <div class="col-sm-4">
                        <p class="text-right">
                            <a href="#top" id="back-top">
                                <i class="fa fa-arrow-up"></i> <?php echo JText::_('TPL_BOOTSTRAP4_BACKTOTOP'); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <jdoc:include type="modules" name="debug" style="none" />
    </body>
</html>