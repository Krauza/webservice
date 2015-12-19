<?php

use Fiche\Application\ControllerFactory;
use Fiche\Application\Exceptions\ControllerNotExists;
use Fiche\Application\Exceptions\ActionNotExists;
use Symfony\Component\HttpFoundation\Request;

function getContentFromController(Silex\Application $app, Request $request, string $controller = 'base', string $action = 'index', $params = null) {
	try {
		$controllerInstance = ControllerFactory::getController($controller, $app['storage'], $request);
		$response = ControllerFactory::callMethod($controllerInstance, $action, $params);
		return $app['twig']->render("/$controller/$action.html.twig", $response);
	} catch(ControllerNotExists $e) {
		$content = 'Controller is not exists';
	} catch(ActionNotExists $e) {
		$content = 'Action is not exists';
	} catch(Exception $e) {
		$content = 'Something went wrong... (' . $e->getMessage() . ')';
	}

	return $app['twig']->render('errors/error-404.html.twig', array('content' => $content));
}
