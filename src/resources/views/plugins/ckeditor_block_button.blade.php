<script>
    editor.addCommand("addBlockDialog", new CKEDITOR.dialogCommand('selectBlockDialog'));
    editor.ui.addButton('SuperButton', {
        label: "Blocks",
        command: 'addBlockDialog',
        toolbar: 'insert',
        icon: '/assets/images/cube.png'
    });
    CKEDITOR.dialog.add('selectBlockDialog', function (editor) {
        return {
            title: 'Select block',
            minWidth: 300,
            minHeight: 100,

            contents: [
                {
                    id: 'block',
                    label: 'Basic Settings',
                    elements: [
                        {
                            type: 'select',
                            id: 'block',
                            label: 'Block name',
                            validate: CKEDITOR.dialog.validate.notEmpty("Field cannot be empty."),
                            items: [],
                            onLoad: function () {
                                var select = this;
                                $.ajax({
                                    url: '/admin/api/blocks',
                                    method: 'get',
                                    success: function (response) {
                                        for (item in response) {
                                            select.add(response[item].translations[0].title, [response[item].system_name]);
                                        }
                                    }
                                });
                            }
                        },
                        {
                            type: 'select',
                            id: 'template',
                            label: 'Block template',
                            validate: CKEDITOR.dialog.validate.notEmpty("Field cannot be empty."),
                            items: [],
                            onLoad: function () {
                                var select = this;
                                $.ajax({
                                    url: '/admin/api/blocks/templates',
                                    method: 'get',
                                    success: function (response) {
                                        console.log(response);
                                        for (item in response) {
                                            select.add(response[item], response[item]);
                                        }
                                    }
                                });
                            }
                        },
                    ]
                }
            ],
            onOk: function () {
                editor.insertText('{block:name=' + this.getValueOf('block', 'block') + ';template=' + this.getValueOf('block', 'template') + '}');
            }
        };
    })


</script>