
<!DOCTYPE html>
<html lang="en-us">
    <head>
    @include("layouts.partials.htmlheader")
    </head>
    <body ng-app="myApp" ng-controller="myController">
        <div id="wrapper">
            @include("layouts.partials.sidebar")
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row" id="main" >
                        <div class="col-sm-12 col-md-12" id="content">
                            @yield("content")
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        @include("layouts.partials.script")
    </body>
</html>