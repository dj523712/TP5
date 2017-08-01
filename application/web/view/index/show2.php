<?php
?>
<html lang="zh-cn">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Textillate.js</title>
{load href="/static/assets/css/animate.css" /}
{load href="/static/assets/css/style.css" /}
{load href="/static/assets/css/init.css" /}
<body>
<div class="decal"></div>
<div class="jumbotron">
    <div class="container">
        <h1 class="glow in tlt">梦想天空</h1>
        <p class="tlt" data-in-effect="bounceInDown">
            A simple plugin for CSS3 text animations.
        </p>
    </div>
</div>
<div class="decal"></div>
<div class="container fade in">
    <div class="grid grid-pad">
        <section class="col-1-1">
            <h2>Playground</h2>
            <div class="playground grid">
                <div class="col-1-1 viewport">
                    <div class="tlt">
                        <ul class="texts" style="display: none">
                            <li>Grumpy wizards make toxic brew for the evil Queen and Jack.</li>
                            <li>The quick brown fox jumps over the lazy dog.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-1-1 controls" style="padding-right: 0">
                    <form class="grid grid-pad">
                        <div class="control col-1-2">
                            <label>In Animation</label>
                            <select data-key="effect" data-type="in"></select>
                            <select data-key="type" data-type="in">
                                <option value="">sequence</option>
                                <option value="reverse">reverse</option>
                                <option value="sync">sync</option>
                                <option value="shuffle">shuffle</option>
                            </select>
                        </div>
                        <div class="control col-1-2">
                            <label>Out Animation</label>
                            <select data-key="effect" data-type="out"></select>
                            <select data-key="type" data-type="out">
                                <option value="">sequence</option>
                                <option value="reverse">reverse</option>
                                <option value="sync">sync</option>
                                <option selected="selected" value="shuffle">shuffle</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="footer-banner" style="width:728px; margin:30px auto"></div>
<script src="http://cdn.staticfile.org/jquery/1.9.0/jquery.min.js"></script>
{load href="/static/assets/js/jquery.fittext.js" /}
{load href="/static/assets/js/jquery.lettering.js" /}
{load href="/static/assets/js/highlight.min.js" /}
{load href="/static/assets/js/jquery.textillate.js" /}
<script>hljs.initHighlightingOnLoad();</script>
<script>
    $(function () {
        var log = function (msg) {
            return function () {
                if (console) console.log(msg);
            }
        }
        $('code').each(function () {
            var $this = $(this);
            $this.text($this.html());
        })

        var animateClasses = 'flash bounce shake tada swing wobble pulse flip flipInX flipOutX flipInY flipOutY fadeIn fadeInUp fadeInDown fadeInLeft fadeInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig fadeOut fadeOutUp fadeOutDown fadeOutLeft fadeOutRight fadeOutUpBig fadeOutDownBig fadeOutLeftBig fadeOutRightBig bounceIn bounceInDown bounceInUp bounceInLeft bounceInRight bounceOut bounceOutDown bounceOutUp bounceOutLeft bounceOutRight rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut';

        var $form = $('.playground form')
            , $viewport = $('.playground .viewport');

        var getFormData = function () {
            var data = {
                loop: true,
                in: {callback: log('in callback called.')},
                out: {callback: log('out callback called.')}
            };

            $form.find('[data-key="effect"]').each(function () {
                var $this = $(this)
                    , key = $this.data('key')
                    , type = $this.data('type');

                data[type][key] = $this.val();
            });

            $form.find('[data-key="type"]').each(function () {
                var $this = $(this)
                    , key = $this.data('key')
                    , type = $this.data('type')
                    , val = $this.val();

                data[type].shuffle = (val === 'shuffle');
                data[type].reverse = (val === 'reverse');
                data[type].sync = (val === 'sync');
            });

            return data;
        };

        $.each(animateClasses.split(' '), function (i, value) {
            var type = '[data-type]'
                , option = '<option value="' + value + '">' + value + '</option>';

            if (/Out/.test(value) || value === 'hinge') {
                type = '[data-type="out"]';
            } else if (/In/.test(value)) {
                type = '[data-type="in"]';
            }

            if (type) {
                $form.find('[data-key="effect"]' + type).append(option);
            }
        });

        $form.find('[data-key="effect"][data-type="in"]').val('fadeInLeftBig');
        $form.find('[data-key="effect"][data-type="out"]').val('hinge');

        $('.jumbotron h1')
            .fitText(0.6)
            .textillate({in: {effect: 'flipInY'}});

        $('.jumbotron p')
            .fitText(3.2, {maxFontSize: 18})
            .textillate({initialDelay: 1000, in: {delay: 3, shuffle: true}});

        setTimeout(function () {
            $('.fade').addClass('in');
        }, 250);

        setTimeout(function () {
            $('h1.glow').removeClass('in');
        }, 2000);

        var $tlt = $viewport.find('.tlt')
            .on('start.tlt', log('start.tlt triggered.'))
            .on('inAnimationBegin.tlt', log('inAnimationBegin.tlt triggered.'))
            .on('inAnimationEnd.tlt', log('inAnimationEnd.tlt triggered.'))
            .on('outAnimationBegin.tlt', log('outAnimationBegin.tlt triggered.'))
            .on('outAnimationEnd.tlt', log('outAnimationEnd.tlt triggered.'))
            .on('end.tlt', log('end.tlt'));

        $form.on('change', function () {
            var obj = getFormData();
            $tlt.textillate(obj);
        }).trigger('change');

    });

</script>
</body>
</html>
