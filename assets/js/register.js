// ================================
// SHOW / HIDE PASSWORD
// ================================

function togglePassword(id, element)
{
    const input = document.getElementById(id);

    const icon = element.querySelector("i");

    if(input.type === "password")
    {
        input.type = "text";

        icon.classList.remove("fa-eye");

        icon.classList.add("fa-eye-slash");
    }
    else
    {
        input.type = "password";

        icon.classList.remove("fa-eye-slash");

        icon.classList.add("fa-eye");
    }
}

// ================================
// PASSWORD MATCH VALIDATION
// ================================

const password = document.getElementById("password");

if(password)
{
    password.addEventListener("keyup", function(){

        const value = password.value;

        const hasUpper = /[A-Z]/.test(value);
        const hasLower = /[a-z]/.test(value);
        const hasNumber = /[0-9]/.test(value);
        const hasSpecial = /[\W_]/.test(value);

        if(value.length < 8)
        {
            password.style.borderColor = "#EF4444";
        }
        else if(hasUpper && hasLower && hasNumber && hasSpecial)
        {
            password.style.borderColor = "#22C55E";
        }
        else
        {
            password.style.borderColor = "#F59E0B";
        }

    });
}

// ================================
// PASSWORD STRENGTH
// ================================

if(password)
{
    password.addEventListener("keyup", function(){

        const value = password.value;

        if(value.length === 0)
        {
            password.style.borderColor = "#CBD5E1";
        }
        else if(value.length < 6)
        {
            password.style.borderColor = "#EF4444";
        }
        else if(value.length < 8)
        {
            password.style.borderColor = "#F59E0B";
        }
        else
        {
            password.style.borderColor = "#22C55E";
        }

    });
}