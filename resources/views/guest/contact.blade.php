<x-guest title="Contact Us">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Get in Touch</h2>
        <p class="text-muted">We’d love to hear from you! Please fill out the form below or reach us directly.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <form action="mailto:kiddoplay2025@gmail.com" method="GET" enctype="text/plain">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Your Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Enter your name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="you@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label fw-semibold">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="4" placeholder="Write your message..."
                            required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <p class="text-muted mb-1"><i class='bx bx-envelope'></i> <a href="mailto:kiddoplay2025@gmail.com" class="text-black text-decoration-none">kiddoplay2025@gmail.com</a></p>
        <p class="text-muted"><i class='bx bx-phone'></i> +1 (800) 555-PLAY</p>
    </div>
</x-guest>
