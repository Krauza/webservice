(function ($) {
    var $card = $('#card');
    var $answerButtons = $('#answer-buttons');
    var $directionButtons = $('#direction-buttons');

    $answerButtons.find('button').on('click', function(event) {
        var $target = $(event.currentTarget);
        var answer = getAnswer($target);

        $card.addClass('show-meaning');
        switchButtons();
        switchCardClass(answer);

        $directionButtons.find('#user-known').val(answer);
        $card.find('.meaning').show(400);
    });

    function switchButtons () {
        $answerButtons.animate({
            opacity: 0
        }, 1000, function() {
            $answerButtons.hide();
            $directionButtons.show();
            $directionButtons.animate({
               opacity: 1
            });
        });
    }

    function switchCardClass (answer) {
        $card.removeClass('alert-warning');

        if(answer) {
            $card.addClass('alert-success');
        } else {
            $card.addClass('alert-danger');
        }
    }

    function getAnswer($button) {
        switch ($button.attr('id')) {
            case 'know':
                return true;
            default:
                return false;
        }
    }
})(window.jQuery);
