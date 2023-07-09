require('./bootstrap');

const message_form = document.getElementById("message_form");
const username_input = document.getElementById("username_input");
const task_input = document.getElementById("task_input");
const message_send = document.getElementById("message_send");
const messages_input = document.getElementById("messages_input");

message_form.addEventListener('submit', function(e) {
    e.preventDefault();
    const options = {
        method: 'post',
        url: '/send-message',
        data: {
            username: username_input,
            message: messages_input,
            task_id: task_input,
        }
    }
    axios(options);
});
Window.Echo.channel('chat')
    .listen('.message', (e) => {
        console.log(e);
    })