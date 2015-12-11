<?php

use Fiche\Application\ControllerFactory;
use Fiche\Application\Exceptions\ControllerNotExists;
use Fiche\Application\Exceptions\ActionNotExists;

function getContentFromController(Silex\Application $app, string $controller = 'base', string $action = 'index', $params = null) {
	try {
		$controllerInstance = ControllerFactory::getController($controller, $app['storage']);
		$response = ControllerFactory::callMethod($controllerInstance, $action, $params);
		return $app['twig']->render("/$controller/$action.html.twig", $response);
	} catch(ControllerNotExists $e) {
		$content = 'Controller is not exists';
	} catch(ActionNotExists $e) {
		$content = 'Action is not exists';
	} catch(Exception $e) {
		$content = 'Something went wrong... (' . $e->getMessage() . ')';
	}

	return $app['twig']->render('error-404.html', array('content' => $content));
}
