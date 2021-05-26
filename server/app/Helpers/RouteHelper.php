<?php

function rawRoute(string $name): string {
    return '/' . app('router')->getRoutes()->getRoutesByName()[$name]->uri;
}
