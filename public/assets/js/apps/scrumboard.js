$(function() {
    var Container = {
        scrumboard: $('.scrumboard'),
        card: $('.scrumboard .card')
    }
    var scrumboard = Container.scrumboard;
    var card = Container.card;

    function addTask() {
        $('.addTask').on('click', function(event) {
            event.preventDefault();
            getParentElement = $(this).parents('[data-connect="sorting"]').attr('data-section');
            $('.edit-task-title').hide();
            $('.add-task-title').show();
            $('[data-btnfn="addTask"]').show();
            $('[data-btnfn="editTask"]').hide();
            // $('.addTaskAccordion .collapse').collapse('hide');
            $('#addTaskModal').modal('show');
            $_taskAdd(getParentElement);
        });
    }
    // Get the range count value
    $('#progress-range-counter').on('input', function(event) {
        event.preventDefault();
        /* Act on the event */
        getRangeValue = $(this).val();
        $('.range-count-number').html(getRangeValue);
        $('.range-count-number').attr('data-rangeCountNumber', getRangeValue);
    });
    // Reset the input Values
    $('#addTaskModal, #addListModal').on('hidden.bs.modal', function(e) {
        $('input,textarea').val('');
        $('input[type="range"]').val(0);
        $('.range-count-number').attr('data-rangecountnumber', 0);
        $('.range-count-number').html(0);
    })


    // Delete the whole list including tasks at on click




    // Clear all task at on click



    // Delete the task on click 

    function $_taskEdit() {
        $('.card .s-task-edit').off('click').on('click', function(event) {

            event.preventDefault();

            var $_outerThis = $(this);

            $('.add-task-title').hide();
            $('.edit-task-title').show();

            $('[data-btnfn="addTask"]').hide();
            $('[data-btnfn="editTask"]').show();

            var $_taskTitle = $_outerThis.parents('.card').find('h4').attr('data-taskTitle');
            var get_value_title = $('.task-text-progress #s-task').val($_taskTitle);

            var $_taskText = $_outerThis.parents('.card').find('p:not(".progress-count")').attr('data-taskText');
            var get_value_text = $('.task-text-progress #s-text').val($_taskText);

            var $_taskProgress = $_outerThis.parents('.card').find('div.progress-bar').attr('data-progressState');
            var get_value_progress = $('#progress-range-counter').val($_taskProgress);
            var get_value_progressHtml = $('.range-count-number').html($_taskProgress);
            var get_value_progressDataAttr = $('.range-count-number').attr('data-rangecountnumber', $_taskProgress);

            $('[data-btnfn="editTask"]').off('click').on('click', function(event) {
                var $_innerThis = $(this);

                var $_taskValue = document.getElementById('s-task').value;
                var $_taskTextValue = document.getElementById('s-text').value;
                var $_taskProgressValue = $('.range-count-number').attr('data-rangeCountNumber');

                var $_taskDataAttr = $_outerThis.parents('.card').find('h4').attr('data-taskTitle', $_taskValue);
                var $_taskTitle = $_outerThis.parents('.card').find('h4').html($_taskValue);
                var $_taskTextDataAttr = $_outerThis.parents('.card').find('p:not(".progress-count")').attr('data-tasktext', $_taskTextValue);
                var $_taskText = $_outerThis.parents('.card').find('p:not(".progress-count")').html($_taskTextValue);

                var $_taskProgressStyle = $_outerThis.parents('.card').find('div.progress-bar').attr('style', "width: " + $_taskProgressValue + "%");
                var $_taskProgressDataAttr = $_outerThis.parents('.card').find('div.progress-bar').attr('data-progressState', $_taskProgressValue);
                var $_taskProgressAriaAttr = $_outerThis.parents('.card').find('div.progress-bar').attr('aria-valuenow', $_taskProgressValue);
                var $_taskProgressProgressCount = $_outerThis.parents('.card').find('.progress-count').html($_taskProgressValue + "%");

                $('#addTaskModal').modal('hide');
                var setDate = $('.taskDate').html('');
                $('.taskDate').hide();
            })
            $('#addTaskModal').modal('show');
        })
    }

    $_editList();
    $_deleteList();
    $_clearList();
    addTask();
    $_taskEdit();
    $_taskDelete();
    $_taskSortable();
    $_taskDetail();

});