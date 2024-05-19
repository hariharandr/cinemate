class LazyLoad {
    constructor(element, offset, fn, direction = 'down') {
        this.element = element;
        this.offset = offset;
        this.fn = fn;
        this.direction = direction;  // 'up' for scroll up, 'down' for scroll down
    }

    watch() {
        this.element.on('scroll', {
            element: this.element,
            offset: this.offset,
            callback: this.fn,
            direction: this.direction,
            lazyload: this
        }, this.checkScrollPosition);
    }

    checkScrollPosition(event) {
        var $element = $(event.data.element);
        var callback = event.data.callback;
        var lazyload = event.data.lazyload;
        var direction = event.data.direction;
        if (direction === 'down') {
            var scrollTop = ($element[0] === window) ? $(window).scrollTop() : $element.scrollTop();
            var innerHeight = ($element[0] === window) ? $(window).height() : $element.innerHeight();
            var scrollHeight = ($element[0] === window) ? $(document).height() : $element[0].scrollHeight;

            // Check the direction and execute the callback accordingly
            if (scrollTop + innerHeight >= scrollHeight - event.data.offset) {
                // Content almost scrolled to the bottom
                callback();
            }
        } else if (direction === 'up') {
            var scrollTop = $element.scrollTop();
            var contentHeight = $element.get(0).scrollHeight - $element.innerHeight();
            // console.log("scrolling");
            // If the content has reached near the top
            if (Math.round(contentHeight) + (scrollTop) <= event.data.offset) {
                // console.log('Content scrolled near to the top!');
                callback();
            }
        }

        // Rebind the scroll event after a delay
        $element.off('scroll');  // Unbind the scroll event to prevent further executions
        setTimeout(function () {
            lazyload.watch();  // Rebind the scroll event after 500 milliseconds
        }, 500);
    }
}