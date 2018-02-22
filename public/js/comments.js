/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/02
 */
var comments = comments || {};

(function (publics) {
  'use strict'

  // ------------------------
  // Privates attributes
  //
  /** @var type (jQuery|null) Container for the comment form wrapper */
  var _container = null
  /** @var type (jQuery|null) Container for the comment form */
  var _form = null
  /** @var type (string|null) Selector based on the CSS */
  var _selector = null

  // ----------------------
  // Privates functions
  //
  var privates = {}
  privates.initVar = function () {
    _container = $('#new_comment')
    _form = $('#comment_new_form')
    _selector = '#new_comment_submit'
  }

  publics.onClickPostedBtn = function () {
    privates.initVar()
    $(_selector).unbind('click').click( function (ev) {
      var _options = {
        type: 'POST',
        url: _form.attr('action'),
        data: _form.serialize(),
        dataType: 'html'
      }
      var jqXhr = $.ajax(_options)
      jqXhr.done(function (data) {
        _container.replaceWith(data)
      })
      ev.preventDefault()
    })
  }
}(comments))
