export function createEditor(elementId) {
    const editors = {};

    CKEDITOR.ClassicEditor
        .create(document.getElementById( elementId ), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'removeFormat', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo', '|',
                    'fontSize', 'fontColor', 'highlight', 'alignment', '|',
                    'specialCharacters'
                ],
                shouldNotGroupWhenFull: true
            },
            fontSize: {
                options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                supportAllValues: true
            },
            placeholder: '',
            // The "super-build" contains more premium features that require additional configuration, disable them below.
            // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
            removePlugins: [
                'CKBox',
                'CKFinder',
                'EasyImage',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData', 
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                'MathType',
                // The following features are part of the Productivity Pack and require additional license.
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents'
            ]
        })
        .then( editor => {
            editors[elementId] = editor;
        } )
        .catch( err => console.error( err.stack ) ); 

    return editors;
}