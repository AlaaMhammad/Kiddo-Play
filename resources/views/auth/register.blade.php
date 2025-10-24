<!doctype html>
<html lang="en" class="layout-wide customizer-hide" dir="ltr" data-skin="default"
    data-assets-path="{{ asset('dashboard/assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Register Parent & Child - {{ env('APP_NAME') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/img/kiddo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('dashboard/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/config.js') }}"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card px-sm-6 px-0">

                    {{-- view all errors --}}

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="app-brand justify-content-center mb-3">
                            <img src="{{ asset('dashboard/assets/img/kiddo.png') }}" alt="logo"
                                style="object-fit: cover; width: 20vw; height: 100px;">
                        </div>

                        <h4 class="mb-1 text-center">Register Parent & Child 👋</h4>
                        <p class="mb-4 text-center">Fill in the details to create an account</p>


                        <form id="parentChildForm" method="POST" action="{{ route('signup') }}">
                            @csrf
                            <!-- Parent Info -->
                            <h6>Parent Info</h6>
                            <div class="mb-3 form-control-validation">
                                <label for="parentName" class="form-label">Name</label>
                                <input type="text" id="parentName" name="parentName" class="form-control" required>
                            </div>
                            <div class="mb-3 form-control-validation">
                                <label for="parentEmail" class="form-label">Email</label>
                                <input type="email" id="parentEmail" name="parentEmail" class="form-control" required>
                            </div>
                            <div class="mb-3 form-password-toggle form-control-validation">
                                <label class="form-label" for="parentPassword">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="parentPassword" name="parentPassword"
                                        class="form-control" required>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle form-control-validation">
                                <label class="form-label" for="parentPassword_confirmation">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="parentPassword_confirmation"
                                        name="parentPassword_confirmation" class="form-control" required>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                            </div>

                            <hr>

                            <!-- Add Child Question -->
                            <div class="mb-3">
                                <label class="form-label">Do you want to add a child?</label>
                                <div>
                                    <button type="button" class="btn btn-outline-primary me-2"
                                        id="addChildYes">Yes</button>
                                    <button type="button" class="btn btn-outline-secondary" id="addChildNo">No</button>
                                </div>
                                <input type="hidden" name="add_child" id="add_child" value="No">
                            </div>

                            <!-- Child Info (Initially Hidden) -->
                            <div id="childSection" style="display:none;">
                                <h6>Child Info</h6>
                                <div id="childrenContainer">
                                    <div class="child-entry mb-3">
                                        <div class="mb-2 form-control-validation">
                                            <label for="childName1" class="form-label">Child Name 1</label>
                                            <input type="text" id="childName1" name="children[0][name]"
                                                class="form-control">
                                        </div>
                                        <div class="mb-2 form-control-validation">
                                            <label for="childDob1" class="form-label">Date of Birth</label>
                                            <input type="date" id="childDob1" name="children[0][dob]"
                                                class="form-control">
                                        </div>
                                        <div class="mb-2 form-control-validation">
                                            <label for="childGender1" class="form-label">Gender</label>
                                            <select id="childGender1" name="children[0][gender]" class="form-select">
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="mb-2 form-control-validation">
                                            <label for="childEmail1" class="form-label">Email</label>
                                            <input type="email" id="childEmail1" name="children[0][email]"
                                                class="form-control">
                                        </div>
                                        <div class="mb-2 form-password-toggle form-control-validation">
                                            <label class="form-label" for="childPassword1">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="childPassword1"
                                                    name="children[0][password]" class="form-control">
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <div class="mb-2 form-password-toggle form-control-validation">
                                            <label class="form-label" for="childPasswordConfirmation1">Confirm
                                                Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="childPasswordConfirmation1"
                                                    name="children[0][password_confirmation]" class="form-control">
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-success mb-3" id="addAnotherChild">Add
                                    Another Child</button>
                                <hr>
                            </div>


                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary d-flex w-100">
                                    <i class='bx bx-check-circle me-1'></i> Register
                                </button>
                            </div>

                            <p class="text-center">
                                <span>Already have an account?</span>
                                <a class="text-primary" href="{{ route('login') }}">
                                    <span>Sign in instead</span>
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('dashboard/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/main.js') }}"></script>

    <script>
        const addChildYes = document.getElementById('addChildYes');
        const addChildNo = document.getElementById('addChildNo');
        const childSection = document.getElementById('childSection');
        const addAnotherChildBtn = document.getElementById('addAnotherChild');
        const childrenContainer = document.getElementById('childrenContainer');

        let childCount = 1;

        addChildYes.addEventListener('click', () => {
            document.getElementById('add_child').value = 'Yes';
            childSection.style.display = 'block';
            addChildYes.classList.remove('btn-outline-primary');
            addChildYes.classList.add('btn-primary');

            addChildNo.classList.remove('btn-danger', 'btn-outline-secondary');
            addChildNo.classList.add('btn-outline-secondary');
        });

        addChildNo.addEventListener('click', () => {
            document.getElementById('add_child').value = 'No';
            childSection.style.display = 'none';
            addChildNo.classList.remove('btn-outline-secondary');
            addChildNo.classList.add('btn-secondary');

            addChildYes.classList.remove('btn-primary');
            addChildYes.classList.add('btn-outline-primary');
        });

        addAnotherChildBtn.addEventListener('click', () => {
            childCount++;
            const newChildHTML = `
    <hr class="text-success">
    <div class="child-entry mb-3">
        <div class="mb-2 form-control-validation">
            <label for="childName${childCount}" class="form-label">Child Name ${childCount}</label>
            <input type="text" id="childName${childCount}" name="children[${childCount-1}][name]" class="form-control">
        </div>
        <div class="mb-2 form-control-validation">
            <label for="childDob${childCount}" class="form-label">Date of Birth</label>
            <input type="date" id="childDob${childCount}" name="children[${childCount-1}][dob]" class="form-control">
        </div>
        <div class="mb-2 form-control-validation">
            <label for="childGender${childCount}" class="form-label">Gender</label>
            <select id="childGender${childCount}" name="children[${childCount-1}][gender]" class="form-select">
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="mb-2 form-control-validation">
            <label for="childEmail${childCount}" class="form-label">Email</label>
            <input type="email" id="childEmail${childCount}" name="children[${childCount-1}][email]" class="form-control">
        </div>
        <div class="mb-2 form-password-toggle form-control-validation">
            <label class="form-label" for="childPassword${childCount}">Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="childPassword${childCount}" name="children[${childCount-1}][password]" class="form-control">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-2 form-password-toggle form-control-validation">
            <label class="form-label" for="childPasswordConfirmation${childCount}">Confirm Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="childPasswordConfirmation${childCount}" name="children[${childCount-1}][password_confirmation]" class="form-control">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
    </div>
    `;
            childrenContainer.insertAdjacentHTML('beforeend', newChildHTML);
        });
    </script>
</body>

</html>
