<?php

use Fiche\Application\ControllerFactory;
use Fiche\Application\Exceptions\ControllerNotExists;
use Fiche\Application\Exceptions\ActionNotExists;
use Symfony\Component\HttpFoundation\Request;

function getContentFromController(Silex\Application $app, Request $request, \string $controller = 'base', \string $action = 'index', $params = null) {
	if (userIsNotSigned($app) && pageIsOnlyForSignedUsers($controller, $action)) {
		return $app->redirect('/auth/login');
	}

	try {
		$controllerInstance = ControllerFactory::getController($controller, $app, $request);
		$response = ControllerFactory::callMethod($controllerInstance, $action, $params);

		if (is_array($response)) {
			return $app['twig']->render("/$controller/$action.html.twig", $response);
		} else {
			return $response;
		}
	} catch(ControllerNotExists $e) {
		$content = 'Controller is not exists';
	} catch(ActionNotExists $e) {
		$content = 'Action is not exists';
	} catch(Exception $e) {
		$content = 'Something went wrong... (' . $e->getMessage() . ')';
	}

	return $app['twig']->render('errors/error-404.html.twig', array('content' => $content));
}

function userIsNotSigned($app)
{
	return empty($app['session']->get('current_user_id'));
}

function pageIsOnlyForSignedUsers(\string $controller, \string $method)
{
	if ($controller === 'auth') {
		return false;
	}

	if ($controller === 'user' && $method === 'register') {
		return false;
	}

	return true;
}
