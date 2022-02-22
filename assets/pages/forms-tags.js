// Wait for the document to fully load.
window.addEventListener( "DOMContentLoaded", async () => {


    // Import and initialize the Bootstrap 5 Tags.
    const { default: Tags } = await import( "/assets/vendors/bootstrap5-tags/tags.min.js" );
    Tags.init();


    // Initialize the Tagin plugin
    for ( const el of document.querySelectorAll( ".tagin" ) ) {
        tagin(el)
    }
})