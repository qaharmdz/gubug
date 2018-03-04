
window.projectVersion = 'master';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Gubug" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Gubug.html">Gubug</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Gubug_Component" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Gubug/Component.html">Component</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Gubug_Component_Config" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Component/Config.html">Config</a>                    </div>                </li>                            <li data-name="class:Gubug_Component_Dispatcher" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Component/Dispatcher.html">Dispatcher</a>                    </div>                </li>                            <li data-name="class:Gubug_Component_Event" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Component/Event.html">Event</a>                    </div>                </li>                            <li data-name="class:Gubug_Component_Request" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Component/Request.html">Request</a>                    </div>                </li>                            <li data-name="class:Gubug_Component_Response" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Component/Response.html">Response</a>                    </div>                </li>                            <li data-name="class:Gubug_Component_Router" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Component/Router.html">Router</a>                    </div>                </li>                            <li data-name="class:Gubug_Component_Session" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Component/Session.html">Session</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Gubug_Event" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Gubug/Event.html">Event</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Gubug_Event_Hook" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Event/Hook.html">Hook</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Gubug_Resolver" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Gubug/Resolver.html">Resolver</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Gubug_Resolver_Argument" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Resolver/Argument.html">Argument</a>                    </div>                </li>                            <li data-name="class:Gubug_Resolver_Controller" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Gubug/Resolver/Controller.html">Controller</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Gubug_Framework" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Gubug/Framework.html">Framework</a>                    </div>                </li>                            <li data-name="class:Gubug_ServiceContainer" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Gubug/ServiceContainer.html">ServiceContainer</a>                    </div>                </li>                            <li data-name="class:Gubug_ServiceProvider" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="Gubug/ServiceProvider.html">ServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Gubug.html", "name": "Gubug", "doc": "Namespace Gubug"},{"type": "Namespace", "link": "Gubug/Component.html", "name": "Gubug\\Component", "doc": "Namespace Gubug\\Component"},{"type": "Namespace", "link": "Gubug/Event.html", "name": "Gubug\\Event", "doc": "Namespace Gubug\\Event"},{"type": "Namespace", "link": "Gubug/Resolver.html", "name": "Gubug\\Resolver", "doc": "Namespace Gubug\\Resolver"},
            
            {"type": "Class", "fromName": "Gubug\\Component", "fromLink": "Gubug/Component.html", "link": "Gubug/Component/Config.html", "name": "Gubug\\Component\\Config", "doc": "&quot;Config is a container for key\/value pairs.&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Component\\Config", "fromLink": "Gubug/Component/Config.html", "link": "Gubug/Component/Config.html#method_get", "name": "Gubug\\Component\\Config::get", "doc": "&quot;Override default getter to use dot-notation&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Config", "fromLink": "Gubug/Component/Config.html", "link": "Gubug/Component/Config.html#method_set", "name": "Gubug\\Component\\Config::set", "doc": "&quot;Override default setter to use dot-notation&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Config", "fromLink": "Gubug/Component/Config.html", "link": "Gubug/Component/Config.html#method_remove", "name": "Gubug\\Component\\Config::remove", "doc": "&quot;Override default remove to use dot-notation&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Config", "fromLink": "Gubug/Component/Config.html", "link": "Gubug/Component/Config.html#method_getArray", "name": "Gubug\\Component\\Config::getArray", "doc": "&quot;Returns the parameter value converted to array.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Config", "fromLink": "Gubug/Component/Config.html", "link": "Gubug/Component/Config.html#method_getDot", "name": "Gubug\\Component\\Config::getDot", "doc": "&quot;Returns a parameter by dot-notation keys.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Config", "fromLink": "Gubug/Component/Config.html", "link": "Gubug/Component/Config.html#method_setDot", "name": "Gubug\\Component\\Config::setDot", "doc": "&quot;Sets a parameter by dot-notation keys.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Config", "fromLink": "Gubug/Component/Config.html", "link": "Gubug/Component/Config.html#method_removeDot", "name": "Gubug\\Component\\Config::removeDot", "doc": "&quot;Remove a parameter by dot-notation keys.&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Component", "fromLink": "Gubug/Component.html", "link": "Gubug/Component/Dispatcher.html", "name": "Gubug\\Component\\Dispatcher", "doc": "&quot;Convert request object to response.&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Component\\Dispatcher", "fromLink": "Gubug/Component/Dispatcher.html", "link": "Gubug/Component/Dispatcher.html#method___construct", "name": "Gubug\\Component\\Dispatcher::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Dispatcher", "fromLink": "Gubug/Component/Dispatcher.html", "link": "Gubug/Component/Dispatcher.html#method_handle", "name": "Gubug\\Component\\Dispatcher::handle", "doc": "&quot;Wrap parent handle to get request type&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Dispatcher", "fromLink": "Gubug/Component/Dispatcher.html", "link": "Gubug/Component/Dispatcher.html#method_subRequest", "name": "Gubug\\Component\\Dispatcher::subRequest", "doc": "&quot;Sub-request simulates URI request, including route parameter and event middleware&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Dispatcher", "fromLink": "Gubug/Component/Dispatcher.html", "link": "Gubug/Component/Dispatcher.html#method_controller", "name": "Gubug\\Component\\Dispatcher::controller", "doc": "&quot;Resolve and call controller directly&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Component", "fromLink": "Gubug/Component.html", "link": "Gubug/Component/Event.html", "name": "Gubug\\Component\\Event", "doc": "&quot;Events central point&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Component\\Event", "fromLink": "Gubug/Component/Event.html", "link": "Gubug/Component/Event.html#method_action", "name": "Gubug\\Component\\Event::action", "doc": "&quot;Shortcut for dispatchHook action&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Event", "fromLink": "Gubug/Component/Event.html", "link": "Gubug/Component/Event.html#method_filter", "name": "Gubug\\Component\\Event::filter", "doc": "&quot;Shortcut for dispatchHook filter&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Event", "fromLink": "Gubug/Component/Event.html", "link": "Gubug/Component/Event.html#method_dispatchHook", "name": "Gubug\\Component\\Event::dispatchHook", "doc": "&quot;Specifically dispatch \\Gubug\\Event\\Hook&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Component", "fromLink": "Gubug/Component.html", "link": "Gubug/Component/Request.html", "name": "Gubug\\Component\\Request", "doc": "&quot;Request represents an HTTP request.&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Component\\Request", "fromLink": "Gubug/Component/Request.html", "link": "Gubug/Component/Request.html#method___construct", "name": "Gubug\\Component\\Request::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Request", "fromLink": "Gubug/Component/Request.html", "link": "Gubug/Component/Request.html#method_getPathInfo", "name": "Gubug\\Component\\Request::getPathInfo", "doc": "&quot;Consistenly remove trailing slash from PathInfo&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Request", "fromLink": "Gubug/Component/Request.html", "link": "Gubug/Component/Request.html#method_getBaseUri", "name": "Gubug\\Component\\Request::getBaseUri", "doc": "&quot;Get base URI for the Request.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Request", "fromLink": "Gubug/Component/Request.html", "link": "Gubug/Component/Request.html#method_getUriForPath", "name": "Gubug\\Component\\Request::getUriForPath", "doc": "&quot;Generates URI for the given path.&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Component", "fromLink": "Gubug/Component.html", "link": "Gubug/Component/Response.html", "name": "Gubug\\Component\\Response", "doc": "&quot;Response represents an HTTP response.&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_setOutput", "name": "Gubug\\Component\\Response::setOutput", "doc": "&quot;A layer for response content&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_getOutput", "name": "Gubug\\Component\\Response::getOutput", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_hasOutput", "name": "Gubug\\Component\\Response::hasOutput", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_hasContent", "name": "Gubug\\Component\\Response::hasContent", "doc": "&quot;Check if response has content&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_prependContent", "name": "Gubug\\Component\\Response::prependContent", "doc": "&quot;Insert content before current response content.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_appendContent", "name": "Gubug\\Component\\Response::appendContent", "doc": "&quot;Insert content after current response content.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_redirect", "name": "Gubug\\Component\\Response::redirect", "doc": "&quot;Redirects to another URL.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_jsonOutput", "name": "Gubug\\Component\\Response::jsonOutput", "doc": "&quot;Return a JSON response.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_fileOutput", "name": "Gubug\\Component\\Response::fileOutput", "doc": "&quot;Send a file.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_abort", "name": "Gubug\\Component\\Response::abort", "doc": "&quot;Aborts current request by sending a HTTP error.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Response", "fromLink": "Gubug/Component/Response.html", "link": "Gubug/Component/Response.html#method_render", "name": "Gubug\\Component\\Response::render", "doc": "&quot;Basic PHP templating&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Component", "fromLink": "Gubug/Component.html", "link": "Gubug/Component/Router.html", "name": "Gubug\\Component\\Router", "doc": "&quot;Wrap Symfony routing under one roof&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Component\\Router", "fromLink": "Gubug/Component/Router.html", "link": "Gubug/Component/Router.html#method___construct", "name": "Gubug\\Component\\Router::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Router", "fromLink": "Gubug/Component/Router.html", "link": "Gubug/Component/Router.html#method_addRoute", "name": "Gubug\\Component\\Router::addRoute", "doc": "&quot;Add route into collection.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Router", "fromLink": "Gubug/Component/Router.html", "link": "Gubug/Component/Router.html#method_newRoute", "name": "Gubug\\Component\\Router::newRoute", "doc": "&quot;Helper on using router route to add collection&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Router", "fromLink": "Gubug/Component/Router.html", "link": "Gubug/Component/Router.html#method_extract", "name": "Gubug\\Component\\Router::extract", "doc": "&quot;Match URL path with a route in collection then extract their attribute.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Router", "fromLink": "Gubug/Component/Router.html", "link": "Gubug/Component/Router.html#method_urlBuild", "name": "Gubug\\Component\\Router::urlBuild", "doc": "&quot;Generate url by route name&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Router", "fromLink": "Gubug/Component/Router.html", "link": "Gubug/Component/Router.html#method_urlGenerate", "name": "Gubug\\Component\\Router::urlGenerate", "doc": "&quot;Helper to automatically check route $name at urlBuild&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Component", "fromLink": "Gubug/Component.html", "link": "Gubug/Component/Session.html", "name": "Gubug\\Component\\Session", "doc": "&quot;Handling HTTP session&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Component\\Session", "fromLink": "Gubug/Component/Session.html", "link": "Gubug/Component/Session.html#method___construct", "name": "Gubug\\Component\\Session::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Session", "fromLink": "Gubug/Component/Session.html", "link": "Gubug/Component/Session.html#method_setOptions", "name": "Gubug\\Component\\Session::setOptions", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Session", "fromLink": "Gubug/Component/Session.html", "link": "Gubug/Component/Session.html#method_flash", "name": "Gubug\\Component\\Session::flash", "doc": "&quot;Message automatically removed once retrieved&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Session", "fromLink": "Gubug/Component/Session.html", "link": "Gubug/Component/Session.html#method_addFlash", "name": "Gubug\\Component\\Session::addFlash", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Component\\Session", "fromLink": "Gubug/Component/Session.html", "link": "Gubug/Component/Session.html#method_getFlash", "name": "Gubug\\Component\\Session::getFlash", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Event", "fromLink": "Gubug/Event.html", "link": "Gubug/Event/Hook.html", "name": "Gubug\\Event\\Hook", "doc": "&quot;Hook event for general action and filter event&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Event\\Hook", "fromLink": "Gubug/Event/Hook.html", "link": "Gubug/Event/Hook.html#method___construct", "name": "Gubug\\Event\\Hook::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Event\\Hook", "fromLink": "Gubug/Event/Hook.html", "link": "Gubug/Event/Hook.html#method_getName", "name": "Gubug\\Event\\Hook::getName", "doc": "&quot;Get triggered event name&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Event\\Hook", "fromLink": "Gubug/Event/Hook.html", "link": "Gubug/Event/Hook.html#method_getDefault", "name": "Gubug\\Event\\Hook::getDefault", "doc": "&quot;Get initial data&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Event\\Hook", "fromLink": "Gubug/Event/Hook.html", "link": "Gubug/Event/Hook.html#method_getAllData", "name": "Gubug\\Event\\Hook::getAllData", "doc": "&quot;Get all changed data by event listener.&quot;"},
            
            {"type": "Class", "fromName": "Gubug", "fromLink": "Gubug.html", "link": "Gubug/Framework.html", "name": "Gubug\\Framework", "doc": "&quot;The Gubug framework class.&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method___construct", "name": "Gubug\\Framework::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method_init", "name": "Gubug\\Framework::init", "doc": "&quot;Initiialize process section&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method_initService", "name": "Gubug\\Framework::initService", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method_initSession", "name": "Gubug\\Framework::initSession", "doc": "&quot;Start session&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method_initApp", "name": "Gubug\\Framework::initApp", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method_coreEvent", "name": "Gubug\\Framework::coreEvent", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method_run", "name": "Gubug\\Framework::run", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method_baseRoute", "name": "Gubug\\Framework::baseRoute", "doc": "&quot;Must be first registered into routeCollection&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Framework", "fromLink": "Gubug/Framework.html", "link": "Gubug/Framework.html#method_dynamicRoute", "name": "Gubug\\Framework::dynamicRoute", "doc": "&quot;Fallback must be last registered at routeCollection&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Resolver", "fromLink": "Gubug/Resolver.html", "link": "Gubug/Resolver/Argument.html", "name": "Gubug\\Resolver\\Argument", "doc": "&quot;Determine the arguments passed to controller method.&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Resolver\\Argument", "fromLink": "Gubug/Resolver/Argument.html", "link": "Gubug/Resolver/Argument.html#method___construct", "name": "Gubug\\Resolver\\Argument::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Argument", "fromLink": "Gubug/Resolver/Argument.html", "link": "Gubug/Resolver/Argument.html#method_getArguments", "name": "Gubug\\Resolver\\Argument::getArguments", "doc": "&quot;Returns the arguments to pass to the controller.&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Argument", "fromLink": "Gubug/Resolver/Argument.html", "link": "Gubug/Resolver/Argument.html#method_parseAttributes", "name": "Gubug\\Resolver\\Argument::parseAttributes", "doc": "&quot;Standardize attributes data&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Argument", "fromLink": "Gubug/Resolver/Argument.html", "link": "Gubug/Resolver/Argument.html#method_cleanArgs", "name": "Gubug\\Resolver\\Argument::cleanArgs", "doc": "&quot;Remove arguments with underscore key&quot;"},
            
            {"type": "Class", "fromName": "Gubug\\Resolver", "fromLink": "Gubug/Resolver.html", "link": "Gubug/Resolver/Controller.html", "name": "Gubug\\Resolver\\Controller", "doc": "&quot;Determine the controller from &#039;_path&#039; or &#039;controler&#039; request attribute.&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\Resolver\\Controller", "fromLink": "Gubug/Resolver/Controller.html", "link": "Gubug/Resolver/Controller.html#method___construct", "name": "Gubug\\Resolver\\Controller::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Controller", "fromLink": "Gubug/Resolver/Controller.html", "link": "Gubug/Resolver/Controller.html#method_getController", "name": "Gubug\\Resolver\\Controller::getController", "doc": "&quot;Get controller from request&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Controller", "fromLink": "Gubug/Resolver/Controller.html", "link": "Gubug/Resolver/Controller.html#method_resolve", "name": "Gubug\\Resolver\\Controller::resolve", "doc": "&quot;Determine controller from &#039;_path&#039; request attribute&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Controller", "fromLink": "Gubug/Resolver/Controller.html", "link": "Gubug/Resolver/Controller.html#method_resolveClass", "name": "Gubug\\Resolver\\Controller::resolveClass", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Controller", "fromLink": "Gubug/Resolver/Controller.html", "link": "Gubug/Resolver/Controller.html#method_resolveMethod", "name": "Gubug\\Resolver\\Controller::resolveMethod", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Controller", "fromLink": "Gubug/Resolver/Controller.html", "link": "Gubug/Resolver/Controller.html#method_resolveArguments", "name": "Gubug\\Resolver\\Controller::resolveArguments", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Gubug\\Resolver\\Controller", "fromLink": "Gubug/Resolver/Controller.html", "link": "Gubug/Resolver/Controller.html#method_exceptionLog", "name": "Gubug\\Resolver\\Controller::exceptionLog", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Gubug", "fromLink": "Gubug.html", "link": "Gubug/ServiceContainer.html", "name": "Gubug\\ServiceContainer", "doc": "&quot;Container of all services&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\ServiceContainer", "fromLink": "Gubug/ServiceContainer.html", "link": "Gubug/ServiceContainer.html#method_setContainer", "name": "Gubug\\ServiceContainer::setContainer", "doc": "&quot;Container setter&quot;"},
                    {"type": "Method", "fromName": "Gubug\\ServiceContainer", "fromLink": "Gubug/ServiceContainer.html", "link": "Gubug/ServiceContainer.html#method_container", "name": "Gubug\\ServiceContainer::container", "doc": "&quot;Full access to container&quot;"},
                    {"type": "Method", "fromName": "Gubug\\ServiceContainer", "fromLink": "Gubug/ServiceContainer.html", "link": "Gubug/ServiceContainer.html#method_use", "name": "Gubug\\ServiceContainer::use", "doc": "&quot;Access a service.&quot;"},
            
            {"type": "Class", "fromName": "Gubug", "fromLink": "Gubug.html", "link": "Gubug/ServiceProvider.html", "name": "Gubug\\ServiceProvider", "doc": "&quot;Register all library to container&quot;"},
                                                        {"type": "Method", "fromName": "Gubug\\ServiceProvider", "fromLink": "Gubug/ServiceProvider.html", "link": "Gubug/ServiceProvider.html#method_register", "name": "Gubug\\ServiceProvider::register", "doc": "&quot;&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


