/**
 * Show toast
 * @param text String text for error message.
 * @param title String title for error message.
 * @param state Int for error state.
 */
function showToast(text, title, state, options = {}) {
    switch (state) {
        case 0:
            toastr.error(text, title, options);
            break;

        case 1:
            toastr.success(text, title, options);
            break;

        case 2:
            toastr.warning(text, title, options);
            break;

        default:
            toastr.info(text, title, options);
            break;
    }
}