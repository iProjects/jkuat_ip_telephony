// Requires underscore for templating

// Make toast available everywhere
window.globalToast = {

    $container: $('#js-toast-container'),

    add: function (model) {
        var toast = new ToastView(model);

        this.$container.append(toast.render().$el);

        return toast;
    }

};

// define the types of toast available
window.ToastTypes = {
    ERROR: 'error',
    ALERT: 'alert',
    SUCCESS: 'success'
};

// Toast class logic
function ToastView(m) {

    // default settings
    this.model = $.extend({
        type: '',
        text: '',
        timeout: 10000,
        dismissable: true,
        buttons: [],
        close: function () { }
    }, m);

    this.$el = $('<div/>');

    // render template with model settings
    this.render = function () {
        var self = this;

        this.$el.html(this.template(this.model));

        // if timeout, set a timer to close toast automatically
        if (this.model.timeout) {
            this.timeout = setTimeout(function () {
                self.close();
            }, this.model.timeout);
        }
        else this.model.dismissable = true;

        // close toast on click
        if (this.model.dismissable) {
            this.$el.one('click', function () {
                self.close();
            });
        }

        // if buttons are available
        // add listeners
        if (this.model.buttons.length) {
            this.$el.on('click', '.js-toast-btn', function (e) {
                e.preventDefault();
                e.stopPropagation(); // stop toast from closing

                var index = +this.getAttribute('data-index');

                if (self.model.buttons[index].callback) self.model.buttons[index].callback.apply(self);
            });
        }

        return this;
    };
    
    this.close = function () {
        var self = this;

        this.model.close();
        window.clearTimeout(this.timeout);
        this.$el.slideUp(function () {
            self.destroy();
        });
    };

    // clear listeners
    this.destroy = function () {
        this.$el.off('click').remove();
    }

}

// compile the template only once
ToastView.prototype.template = _.template($('#js-api-toast-template').html());

$(function() {
  globalToast.add({
      text: 'Click the buttons on the left to create another toast notification. This is what a default notification looks like.',
      timeout: 0
    });
  
  $('.js-add-notification').on('click', function() {
    globalToast.add({
        type: ToastTypes.SUCCESS,
      text: 'This is a success notification. Click to dismiss. Closes itself after 10 sec.'
    });
  });
    
  $('.js-add-alert').on('click', function() {
    globalToast.add({
        type: ToastTypes.ALERT,
      text: 'This is an alert. Click to dismiss. Closes itself after 10 sec.'
    });
  });
  
  $('.js-add-error').on('click', function() {
    globalToast.add({
        type: ToastTypes.ERROR,
      text: 'This is an error. Click to dismiss. Closes itself after 10 sec.'
    });
  });
    
  $('.js-add-btn').on('click', function() {
    globalToast.add({
        type: ToastTypes.SUCCESS,
      text: 'This is a notification with a button. Click to dismiss. Closes itself after 10 sec.',
        buttons: [
            {
                text: 'Click me',
                callback: function() {
                    alert('you clicked me');
                }
            }
        ]
    });
  });
});