$(function() {
    $("#modules_tree").jstree({
        "plugins": ["wholerow", "checkbox"],
        "core": {
            "themes": {
                "name": "proton",
                "responsive": true
            }
        }
    });
    $("#modules_tree").jstree().close_all();
    /*setTimeout(function(){
     $("#modules_tree").jstree().open_all();
     $('li[data-checked="true"]').each(function() {
     $("#modules_tree").jstree('check_node', $(this));
     });
     $("#modules_tree").jstree().close_all();
     },3000);*/
    $("body").on("click", 'input[type="submit"]', function () {
        var selectedElmsIds={};
        var selectedElms = $("#modules_tree").jstree("get_selected", true);

        var moduleName = '',
            controllerName = '',
            actionName = '';
        $.each(selectedElms, function () {
            var id = this.id.split('-');
            moduleName = id[0];
            controllerName = id[1];
            actionName = id[2];

            //if (controllerName != undefined && actionName != undefined) {
                if (eval("selectedElmsIds." + moduleName + "." + controllerName) == undefined)
                    eval("selectedElmsIds." + moduleName + "." + controllerName + " = new Array()");
                eval("selectedElmsIds." + moduleName + "." + controllerName + ".push(\'" + actionName + "\')");
            //}
        });
        console.log(selectedElmsIds);
        return false;
        $("#js-tree-permissions").val(JSON.stringify(selectedElmsIds));
    });
});