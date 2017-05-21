/*!
 * Bootstrap v3.3.7 (http://getbootstrap.com)
 * Copyright 2011-2017 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

/*!
 * Generated using the Bootstrap Customizer (http://getbootstrap.com/customize/?id=179b51f8a69e28f3bb3b2bc663c1ae52)
 * Config saved to config.json and https://gist.github.com/179b51f8a69e28f3bb3b2bc663c1ae52
 */
if (typeof jQuery === 'undefined') {
  throw new Error('Bootstrap\'s JavaScript requires jQuery')
}
+function ($) {
  'use strict';
  var version = $.fn.jquery.split(' ')[0].split('.')
  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1) || (version[0] > 3)) {
    throw new Error('Bootstrap\'s JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4')
  }
}(jQuery);

/* ========================================================================
 * Bootstrap: VHDmodal.js v3.3.7
 * http://getbootstrap.com/javascript/#VHDmodals
 * ========================================================================
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // MODAL CLASS DEFINITION
  // ======================

  var VHDModal = function (element, options) {
    this.options             = options
    this.$body               = $(document.body)
    this.$element            = $(element)
    this.$dialog             = this.$element.find('.VHDmodal-dialog')
    this.$backdrop           = null
    this.isShown             = null
    this.originalBodyPad     = null
    this.scrollbarWidth      = 0
    this.ignoreBackdropClick = false

    if (this.options.remote) {
      this.$element
        .find('.VHDmodal-content')
        .load(this.options.remote, $.proxy(function () {
          this.$element.trigger('loaded.bs.VHDmodal')
        }, this))
    }
  }

  VHDModal.VERSION  = '3.3.7'

  VHDModal.TRANSITION_DURATION = 300
  VHDModal.BACKDROP_TRANSITION_DURATION = 150

  VHDModal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  VHDModal.prototype.toggle = function (_relatedTarget) {
    return this.isShown ? this.hide() : this.show(_relatedTarget)
  }

  VHDModal.prototype.show = function (_relatedTarget) {
    var that = this
    var e    = $.Event('show.bs.VHDmodal', { relatedTarget: _relatedTarget })

    this.$element.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.checkScrollbar()
    this.setScrollbar()
    this.$body.addClass('VHDmodal-open')

    this.escape()
    this.resize()

    this.$element.on('click.dismiss.bs.VHDmodal', '[data-dismiss="VHDmodal"]', $.proxy(this.hide, this))

    this.$dialog.on('mousedown.dismiss.bs.VHDmodal', function () {
      that.$element.one('mouseup.dismiss.bs.VHDmodal', function (e) {
        if ($(e.target).is(that.$element)) that.ignoreBackdropClick = true
      })
    })

    this.backdrop(function () {
      var transition = $.support.transition && that.$element.hasClass('VHDfade')

      if (!that.$element.parent().length) {
        that.$element.appendTo(that.$body) // don't move VHDmodals dom position
      }

      that.$element
        .show()
        .scrollTop(0)

      that.adjustDialog()

      if (transition) {
        that.$element[0].offsetWidth // force reflow
      }

      that.$element.addClass('in')

      that.enforceFocus()

      var e = $.Event('shown.bs.VHDmodal', { relatedTarget: _relatedTarget })

      transition ?
        that.$dialog // wait for VHDmodal to slide in
          .one('bsTransitionEnd', function () {
            that.$element.trigger('focus').trigger(e)
          })
          .emulateTransitionEnd(VHDModal.TRANSITION_DURATION) :
        that.$element.trigger('focus').trigger(e)
    })
  }

  VHDModal.prototype.hide = function (e) {
    if (e) e.preventDefault()

    e = $.Event('hide.bs.VHDmodal')

    this.$element.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.escape()
    this.resize()

    $(document).off('focusin.bs.VHDmodal')

    this.$element
      .removeClass('in')
      .off('click.dismiss.bs.VHDmodal')
      .off('mouseup.dismiss.bs.VHDmodal')

    this.$dialog.off('mousedown.dismiss.bs.VHDmodal')

    $.support.transition && this.$element.hasClass('VHDfade') ?
      this.$element
        .one('bsTransitionEnd', $.proxy(this.hideVHDModal, this))
        .emulateTransitionEnd(VHDModal.TRANSITION_DURATION) :
      this.hideVHDModal()
  }

  VHDModal.prototype.enforceFocus = function () {
    $(document)
      .off('focusin.bs.VHDmodal') // guard against infinite focus loop
      .on('focusin.bs.VHDmodal', $.proxy(function (e) {
        if (document !== e.target &&
            this.$element[0] !== e.target &&
            !this.$element.has(e.target).length) {
          this.$element.trigger('focus')
        }
      }, this))
  }

  VHDModal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keydown.dismiss.bs.VHDmodal', $.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.$element.off('keydown.dismiss.bs.VHDmodal')
    }
  }

  VHDModal.prototype.resize = function () {
    if (this.isShown) {
      $(window).on('resize.bs.VHDmodal', $.proxy(this.handleUpdate, this))
    } else {
      $(window).off('resize.bs.VHDmodal')
    }
  }

  VHDModal.prototype.hideVHDModal = function () {
    var that = this
    this.$element.hide()
    this.backdrop(function () {
      that.$body.removeClass('VHDmodal-open')
      that.resetAdjustments()
      that.resetScrollbar()
      that.$element.trigger('hidden.bs.VHDmodal')
    })
  }

  VHDModal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove()
    this.$backdrop = null
  }

  VHDModal.prototype.backdrop = function (callback) {
    var that = this
    var animate = this.$element.hasClass('VHDfade') ? 'VHDfade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $(document.createElement('div'))
        .addClass('VHDmodal-backdrop ' + animate)
        .appendTo(this.$body)

      this.$element.on('click.dismiss.bs.VHDmodal', $.proxy(function (e) {
        if (this.ignoreBackdropClick) {
          this.ignoreBackdropClick = false
          return
        }
        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.$element[0].focus()
          : this.hide()
      }, this))

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      if (!callback) return

      doAnimate ?
        this.$backdrop
          .one('bsTransitionEnd', callback)
          .emulateTransitionEnd(VHDModal.BACKDROP_TRANSITION_DURATION) :
        callback()

    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in')

      var callbackRemove = function () {
        that.removeBackdrop()
        callback && callback()
      }
      $.support.transition && this.$element.hasClass('VHDfade') ?
        this.$backdrop
          .one('bsTransitionEnd', callbackRemove)
          .emulateTransitionEnd(VHDModal.BACKDROP_TRANSITION_DURATION) :
        callbackRemove()

    } else if (callback) {
      callback()
    }
  }

  // these following methods are used to handle overflowing VHDmodals

  VHDModal.prototype.handleUpdate = function () {
    this.adjustDialog()
  }

  VHDModal.prototype.adjustDialog = function () {
    var VHDmodalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight

    this.$element.css({
      paddingLeft:  !this.bodyIsOverflowing && VHDmodalIsOverflowing ? this.scrollbarWidth : '',
      paddingRight: this.bodyIsOverflowing && !VHDmodalIsOverflowing ? this.scrollbarWidth : ''
    })
  }

  VHDModal.prototype.resetAdjustments = function () {
    this.$element.css({
      paddingLeft: '',
      paddingRight: ''
    })
  }

  VHDModal.prototype.checkScrollbar = function () {
    var fullWindowWidth = window.innerWidth
    if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
      var documentElementRect = document.documentElement.getBoundingClientRect()
      fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left)
    }
    this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth
    this.scrollbarWidth = this.measureScrollbar()
  }

  VHDModal.prototype.setScrollbar = function () {
    var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
    this.originalBodyPad = document.body.style.paddingRight || ''
    if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
  }

  VHDModal.prototype.resetScrollbar = function () {
    this.$body.css('padding-right', this.originalBodyPad)
  }

  VHDModal.prototype.measureScrollbar = function () { // thx walsh
    var scrollDiv = document.createElement('div')
    scrollDiv.className = 'VHDmodal-scrollbar-measure'
    this.$body.append(scrollDiv)
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
    this.$body[0].removeChild(scrollDiv)
    return scrollbarWidth
  }


  // MODAL PLUGIN DEFINITION
  // =======================

  function Plugin(option, _relatedTarget) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.VHDmodal')
      var options = $.extend({}, VHDModal.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('bs.VHDmodal', (data = new VHDModal(this, options)))
      if (typeof option == 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  var old = $.fn.VHDmodal

  $.fn.VHDmodal             = Plugin
  $.fn.VHDmodal.Constructor = VHDModal


  // MODAL NO CONFLICT
  // =================

  $.fn.VHDmodal.noConflict = function () {
    $.fn.VHDmodal = old
    return this
  }


  // MODAL DATA-API
  // ==============

  $(document).on('click.bs.VHDmodal.data-api', '[data-toggle="VHDmodal"]', function (e) {
    var $this   = $(this)
    var href    = $this.attr('href')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
    var option  = $target.data('bs.VHDmodal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

    if ($this.is('a')) e.preventDefault()

    $target.one('show.bs.VHDmodal', function (showEvent) {
      if (showEvent.isDefaultPrevented()) return // only register focus restorer if VHDmodal will actually get shown
      $target.one('hidden.bs.VHDmodal', function () {
        $this.is(':visible') && $this.trigger('focus')
      })
    })
    Plugin.call($target, option, this)
  })

}(jQuery);
