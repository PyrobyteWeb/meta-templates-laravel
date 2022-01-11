<?php

namespace PyrobyteWeb\MetaTemplates\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MetaTemplateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $currentRouteName = Route::currentRouteName();
        $templatePlaceholderRender = config('meta-templates');

        if (
            is_null($currentRouteName)
            || empty($template = \PyrobyteWeb\MetaTemplates\Models\MetaTemplate::getTemplate($currentRouteName))
            || empty($templatePlaceholderRender)
        ){
            return $next($request);
        }

        $meta = app('meta');
        $templatePlaceholderRender = config('meta-templates');

        if (array_key_exists($currentRouteName, $templatePlaceholderRender['custom'])) {
            $templatePlaceholderRender = new $templatePlaceholderRender['custom'][$currentRouteName];
            $meta->setTitle($templatePlaceholderRender->replace($template->getMetaTitle()));
            $meta->setDescription($templatePlaceholderRender->replace($template->getMetaDescription()));
            $meta->setKeywords($templatePlaceholderRender->replace($template->getMetaKeywords()));
        }

        return $next($request);
    }
}
