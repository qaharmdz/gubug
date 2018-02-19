<?php
namespace Contoh\App;

use Gubug\ServiceContainer;

// Service available through extending ServiceContainer
class Home extends ServiceContainer
{
    public function index()
    {
        $message = $this->use('config')->get('locale') == 'id' ? 'Selamat datang di "Gubug"' : 'Welcome to Gubug';

        return $this->use('response')->setContent($message);
    }

    public function post(...$args)
    {
        !d('Arguments passed to method', $args);
        d('All request attribute', $this->use('request')->attributes->all());

        return $this->use('response')->setContent('Post #' . $args['pid'] . ' Content');
    }

    public function url()
    {
        $data = [];

        // Shortcut to Symfony urlGenerator
        $data['urlBuild()'] = [
            // $this->use('router')->urlBuild($routerName, $parameters, $extraParam),

            'base'       => $this->use('router')->urlBuild('base'),
            'base_param' => $this->use('router')->urlBuild(
                'base',                     // Router name, fail if no match
                ['param' => 'query'],       // Router parameter, if no parameter match it will become URL query
                false                       // Append extra parameter? default True
            ),
            'post'       => $this->use('router')->urlBuild('app/home/post', [], false),
            'post_param' =>$this->use('router')->urlBuild(
                'app/home/post',
                [
                    'pid'    => 16,
                    'cid'    => '32_64',
                    'custom' => 'override'  // custom parameter cannot be overriden
                ]
            ),
            'render'     => $this->use('router')->urlBuild('app/home/render', [], false),
            'dynamic'    => $this->use('router')->urlBuild('app/home/render', [], false),
        ];

        // Automatically recognise route name based on path (this is reason why we recommend: $routeName == $param['_path'] )
        $data['urlGenerate()'] = [
            // $this->use('router')->urlGenerate($path, $parameters, $extraParam),

            'base'         => $this->use('router')->urlGenerate(''),
            'base_notoken' => $this->use('router')->urlGenerate('', [], false),
            'post'         => $this->use('router')->urlGenerate('app/home/post', ['pid' => 16, 'cid' => '32_64'], false),
            'dynamic'      => $this->use('router')->urlGenerate('app/home/render', [], false),

        ];

        !d($data);

        return $this->use('response')->setContent('urlBuild require to know the exact route name or it will fail');
    }


    public function render(...$args)
    {
        d($args);
        $data = [];
        $data['baseUri'] = $this->use('request')->getBaseUri();

        $data['title'] = 'Gubug Render Example';
        $data['param'] = [
            'arguments'     => $args,
            'attributes'    => $this->use('request')->attributes->all()
        ];
        $data['extraservice'] = [
            'name'      => $this->use('faker')->name,
            'address'   => $this->use('faker')->address,
            'phone'     => $this->use('faker')->tollFreePhoneNumber,
        ];

        //=== $response->send(true) stop script execution with exit()
        // $this->use('response')->setContent('Hijack');
        // $this->use('response')->send(true);

        //=== $response->abort() halt script by throwing HTTP error
        // $this->use('response')->abort(500, 'Oops! Script halted due the internal server error.');

        $template = $this->use('config')->get('basePath') . 'View/template.tpl';
        return $this->use('response')->render($template, $data);
    }
}