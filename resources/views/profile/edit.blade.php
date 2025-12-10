<!-- ======================== -->
<!--   MODAL EDIT PROFILE     -->
<!-- ======================== -->

<style>
    /* Background modal */
    #editProfileModal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
        z-index: 99999;
    }

    /* Box modal */
    .modal-box {
        background: white;
        padding: 25px;
        width: 380px;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.2);
        animation: fadeIn 0.2s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-top: 5px;
        margin-bottom: 15px;
    }

    .modal-btn {
        padding: 10px;
        width: 100%;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-save {
        background: #ff7d28;
        color: white;
        margin-bottom: 10px;
    }

    .btn-cancel {
        background: #ddd;
    }
</style>


<!-- BUTTON DI NAVBAR -->
<li onclick="openEditProfile()" style="cursor:pointer;">
    Edit Profile
</li>


<!-- MODAL EDIT PROFILE -->
<div id="editProfileModal">
    <div class="modal-box">

        <h3 style="margin-bottom: 15px;">Edit Profile</h3>

        <label>Nama Lengkap</label>
        <input type="text" id="profileName" class="modal-input">

        <label>Email Address</label>
        <input type="email" id="profileEmail" class="modal-input">

        <button class="modal-btn btn-save" onclick="saveProfile()">Save Changes</button>
        <button class="modal-btn btn-cancel" onclick="closeEditProfile()">Cancel</button>

    </div>
</div>


<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* ============================
        BUKA MODAL & LOAD DATA USER
       ============================ */
    function openEditProfile() {
        fetch("/api/user")
            .then(res => res.json())
            .then(user => {
                document.getElementById("profileName").value = user.name;
                document.getElementById("profileEmail").value = user.email;
                document.getElementById("editProfileModal").style.display = "flex";
            });
    }

    function closeEditProfile() {
        document.getElementById("editProfileModal").style.display = "none";
    }


    /* ============================
        SIMPAN PROFILE (AJAX)
       ============================ */
    function saveProfile() {
        let name = document.getElementById("profileName").value;
        let email = document.getElementById("profileEmail").value;

            fetch("{{ route('profile.update') }}", {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({ name, email })
        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: data.message,
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 2500
            });

            closeEditProfile();
        })
        .catch(() => {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Terjadi kesalahan sistem"
            });
        });
    }
</script>
