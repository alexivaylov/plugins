<?php

class LM3Plugin extends ZAppsPlugin {
	
	public function resolveMVCEnter($context) {
	}
	
	public function resolveMVCLeave($context) {
		if (!$this->resolved) {
			$routeMatch = $context['functionArgs'][0];
			if ($routeMatch) {
				$params = $routeMatch->getParams();
				if ($params) {
					$this->resolved = true;
					$mvc = array();
					if (isset($params['module'])) {
						$mvc['module'] = $params['module'];
					}
					if (isset($params['controller'])) {
						$mvc['controller'] = $params['controller'];
					}
					if (isset($params['action'])) {
						$mvc['action'] = $params['action'];
					}
					
					$this->setRequestMVC($mvc);
				}
			}
		}
	}		
	
	private $resolved = false;
}

$LM3Plugin = new LM3Plugin();
$LM3Plugin->setWatchedFunction("Laminas\Mvc\MvcEvent::setRouteMatch", array($LM3Plugin, "resolveMVCEnter"), array($LM3Plugin, "resolveMVCLeave"));