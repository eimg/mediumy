(function (root, factory) {
    'use strict';
    if (typeof module === 'object') {
        module.exports = factory;
    } else if (typeof define === 'function' && define.amd) {
        define(factory);
    } else {
        root.AutoList = factory;
    }
}(this, function (MediumEditor) {

var AutoList = MediumEditor.Extension.extend({
    name: 'autolist',
    init: function(){
      this.subscribe('editableKeypress', this.onKeypress.bind(this));
    },
    onKeypress: function (keyPressEvent) {
     if (MediumEditor.util.isKey(keyPressEvent, [MediumEditor.util.keyCode.SPACE])) {
          var list_start = this.base.getSelectedParentElement().textContent;
          if (list_start == "1."  && this.base.getExtensionByName('orderedlist')){
            this.base.execAction('insertorderedlist');
            this.base.getSelectedParentElement().textContent = this.base.getSelectedParentElement().textContent.slice(2).trim();
          }
          else if( list_start == "*" && this.base.getExtensionByName('unorderedlist')){
            this.base.execAction('insertunorderedlist');
            this.base.getSelectedParentElement().textContent = this.base.getSelectedParentElement().textContent.slice(1).trim();
          }
      }
    }
  });

  return AutoList;

}(typeof require === 'function' ? require('medium-editor') : MediumEditor)));
