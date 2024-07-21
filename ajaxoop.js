class FormValidator {
    constructor(formId, statusId, scriptUrl) {
        this.formId = formId;
        this.statusId = statusId;
        this.scriptUrl = scriptUrl;
        this.init();
    }

    init() {
        $(`#${this.formId}`).submit((e) => this.handleSubmit(e));
    }

    handleSubmit(e) {
        e.preventDefault();
        this.resetErrors();

        $.ajax({
            url: this.scriptUrl,
            type: 'post',
            data: new FormData($(`#${this.formId}`)[0]),
            dataType: 'json',
            processData: false,
            contentType: false,
            success: (formresult) => this.handleSuccess(formresult)
        });
    }

    handleSuccess(formresult) {
        if (formresult.redirect == 'candidatepage') {      //Redirecting to candidate or recruiter page when login is successfull
        window.location.href = "candidate.php";
        }
        if (formresult.redirect == 'recruiterpage') {      //Redirecting to candidate or recruiter page when login is successfull
            window.location.href = "recruiter.php";
        }
        if (formresult.redirect == 'adminpage') {      //Redirecting to admin page when login is successfull
            window.location.href = "adminpage.php";
        }
        if(formresult.status === 'jobupdated'){
            $(`#${this.statusId}`).show().addClass('text-success').html(formresult.data);

            $(document).ready(function(){                
                setTimeout(function(){
                    location.reload();
                }, 2000); // 2000 milliseconds = 2 seconds
            });   //On updating the job the page is required to refresh to display the changes
        }

        if(formresult.status === 'adminupdateprocess'){
            $(`#${this.statusId}`).show().addClass('text-success').html(formresult.data);

            setTimeout(() => {
                $(`#${this.statusId}`).hide();
            }, 2000);

        } 

        if (formresult.status === true) {
            $(`#${this.statusId}`).show().addClass('text-success').html(formresult.data);
            $(`#${this.formId}`)[0].reset();
            
            setTimeout(() => {
                $(`#${this.statusId}`).hide();
            }, 2000);

        } else if (formresult.status === false) {
            this.displayErrors(formresult.data);
            const keys = Object.keys(formresult.data);
            $(`input[name="${keys[0]}"]`).focus();
        }
    }

    displayErrors(errors) {
        $.each(errors, (key, value) => {
            const errordisplay = `<label class="text-danger" style="display:block; position: absolute;" for="${key}">${value}</label>`;
            $(`input[name="${key}"]`).addClass('is-invalid').after(errordisplay);
            $(`select[name="${key}"]`).addClass('is-invalid').after(errordisplay);
        });
    }

    resetErrors() {
        $(`#${this.formId} input, #${this.formId} select`).removeClass('is-invalid');
        $('label.text-danger').remove();
    }
}

// Usage example:
// $(document).ready(function() {
//     new FormValidator('regform', 'submissionstatus', 'script.php');
    // Initialize another form validator if needed:
    // new FormValidator('anotherFormId', 'anotherStatusId', 'anotherScript.php');
// });
