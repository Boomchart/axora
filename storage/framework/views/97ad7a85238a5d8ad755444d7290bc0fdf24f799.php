<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        :root {
            --dark: #78fad1;
            --light: #ffffff;
            --success: #0abf30;
            --error: #e24d4c;
            --err: #e24d4c;
            --warning: #e9bd0c;
            --info: #3498db;
        }

        .xnotification {
            position: fixed;
            z-index: 9999;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .xnotification :where(.xtoast, .column) {
            display: flex;
            align-items: center;
        }

        .xnotification .xtoast {
            width: 400px;
            position: relative;
            overflow: hidden;
            list-style: none;
            border-radius: 14px;
            padding: 1px 17px;
            margin-bottom: 10px;
            /* background-color: rgb(26, 25, 26); */
            background: rgba(227, 225, 225, 0.9) !important;
            justify-content: space-between;
            animation: show_toast 0.3s ease forwards;
        }

        @keyframes show_toast {
            0% {
                transform: translateX(100%);
            }

            40% {
                transform: translateX(-5%);
            }

            80% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-10px);
            }
        }

        .xnotification .xtoast.hide {
            animation: hide_toast 0.3s ease forwards;
        }

        @keyframes hide_toast {
            0% {
                transform: translateX(-10px);
            }

            40% {
                transform: translateX(0%);
            }

            80% {
                transform: translateX(-5%);
            }

            100% {
                transform: translateX(calc(100% + 20px));
            }
        }

        .xtoast::before {
            position: absolute;
            content: "";
            height: 2.5px;
            width: 100%;
            bottom: 0px;
            left: 0px;
            animation: progress 5s linear forwards;
            display: none;
            /* remove this property to simulate a progress bar */
        }

        @keyframes progress {
            100% {
                width: 0;
            }
        }

        .xtoast .column i {
            font-size: 2.5rem;
        }

        .xtoast.success .column i {
            color: var(--success);
        }

        .xtoast.error .column i {
            color: var(--error);
        }

        .xtoast.warning .column i {
            color: var(--warning);
        }

        .xtoast.info .column i {
            color: var(--info);
        }

        .xtoast .column span {
            font-size: 0.9rem;
            margin-left: 12px;
            font-weight: 200;
            color: #000;
        }

        .xtoast i:last-child {
            color: #aeb0d7;
            cursor: pointer;
        }

        .xtoast i:last-child:hover {
            color: var(--dark);
        }

        .iconsuccess {
            color: var(--success);
        }

        .iconerror {
            background-color: var(--error);
            padding: 2px 5px 2px 5px;
            border-radius: 50%;
        }

        .iconalert {
            color: var(--warning);
        }

        @media screen and (max-width: 530px) {
            .xnotification {
                width: 100%;
            }

            .xnotification .xtoast {
                width: 100%;
                font-size: 1.1rem;
                margin-left: 20px;
                padding: 16px 17px;
            }
        }
    </style>
</head>

<body>
    <ul class="xnotification"></ul>
    <script>
        const xnotifications = document.querySelector(".xnotification");

        const toastDetails = {
            timer: 5000,
            success: {
                icon: "bi bi-check2-circle fs-3x iconsuccess"
            },
            error: {
                icon: "bi bi-x-lg fs-3x iconerror"
            },
            warning: {
                icon: "bi bi-exclamation-circle fs-3x iconalert"
            }
        }

        const removeToast = (toast) => {
            toast.classList.add("hide")
            if (toast.timeoutId) clearTimeout(toast.timeoutId)
            setTimeout(() => toast.remove(), 5000)
        }

        // Function to find existing toast of the same type
        const findExistingToast = (type) => {
            return xnotifications.querySelector(`.xtoast.${type}`);
        }

        const createToast = (id, message) => {
            // Check if toast of same type already exists
            const existingToast = findExistingToast(id);

            if (existingToast) {
                // Update existing toast message
                const messageSpan = existingToast.querySelector('span');
                messageSpan.textContent = message;

                // Reset timer
                if (existingToast.timeoutId) {
                    clearTimeout(existingToast.timeoutId);
                }
                existingToast.timeoutId = setTimeout(() => removeToast(existingToast), toastDetails.timer);
                return;
            }

            // Create new toast only if none exists for this type
            const {
                icon
            } = toastDetails[id];
            const toast = document.createElement("li");
            toast.className = `xtoast ${id}`;
            toast.innerHTML = `<div class="column">
                     <i class="${icon}"></i>
                     <span>${message}</span>
                  </div>
                  <i style="color: #000" class="bi bi-x-lg fs-1" onclick="removeToast(this.parentElement)"></i>`;

            xnotifications.appendChild(toast);
            toast.timeoutId = setTimeout(() => removeToast(toast), toastDetails.timer);
        }

        window.addEventListener("livewire:load", () => {
            window.livewire.on('success', (message) => {
                createToast("success", message);
            })
            window.livewire.on('alert', (message) => {
                createToast("warning", message);
            })
        });
    </script>
</body>

</html><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/components/laralert.blade.php ENDPATH**/ ?>