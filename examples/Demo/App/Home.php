<?php
namespace Contoh\App;

use Symfony\Component\HttpKernel\HttpKernelInterface;

// Service available through extending ServiceContainer
class Home extends \Gubug\ServiceContainer
{
    public function index()
    {
        $message = $this->use('request')->getLocale() == 'id' ? 'Selamat datang di "Gubug"' : 'Welcome to Gubug';

        return $this->use('response')->setContent($message);
    }

    public function post($args = [])
    {
        // !d('Arguments passed to method', $args);
        // d('All request attribute', $this->use('request')->attributes->all());

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

        // Automatically recognise route name based on path (reason why we recommend: $routeName == $param['_path'] )
        $data['urlGenerate()'] = [
            // $this->use('router')->urlGenerate($path, $parameters, $extraParam),

            'base'         => $this->use('router')->urlGenerate(''),
            'base_notoken' => $this->use('router')->urlGenerate('', [], false),
            'post'         => $this->use('router')->urlGenerate('app/home/post', ['pid' => 16, 'cid' => '32_64'], false),
            'dynamic'      => $this->use('router')->urlGenerate('app/home/render', [], false),

        ];

        !d($data);

        return $this->use('response')->setContent('<b>urlGenerate</b> check the path and map automatically, while <b>urlBuild</b> require to know the exact route name or it will fail');
    }


    public function render($args = [])
    {
        $data = [];
        $data['baseUri'] = $this->use('request')->getBaseUri();

        $data['title'] = 'Template Render Example';
        $data['param'] = [
            'arguments'     => $args,
            'attributes'    => $this->use('request')->attributes->all()
        ];

        // === Uncomment to see 'title' change through filter hook
        $data = $this->use('event')->filter('home.renderData', $data);

        // === $response->abort() halt script by throwing HTTP error
        // $this->use('response')->abort(500, 'Oops! Script halted due the internal server error.');

        $template = $this->use('config')->get('basePath') . 'View/template.tpl';
        // return $this->use('response')->render($template, $data);

        return $this->use('response')->render($template, $data);
        // return $this->use('response')->render($template, $data)->setOutput();
    }

    public function test($args = [])
    {
        // === Sub-request simulates URI request including go through all event middleware

        // return $this->use('dispatcher')->subRequest('id/app/home/render/foo/bar');

        // return $this->use('dispatcher')->subRequest('post/56/23_4');

        // === Directly call controller

        return $this->use('dispatcher')->controller('app/home/render/foo/bar', ['baz' => 'world']);

        // ==================================

        // return $this->use('response')->jsonOutput([1, 2, 'foo' => [3, 4]]);
        // return $this->use('response')->redirect('app/home/render/foo/bar');
    }
}
