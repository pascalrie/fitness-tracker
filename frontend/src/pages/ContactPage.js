import React from 'react';
import styles from '../styles/ContactPage.css';

const ContactPage = () => {
    return (
        <div className={styles.container}>
            <h1>Contact</h1>
            <p>If you have any questions, feedback, or need support, feel free to reach out! I'd love to hear from
                you.</p>
            <h2>Contact Information</h2>
            <p className={styles['contact-info']}>
                <strong>Email:</strong> <a href="mailto:support@example.example">support@example.example</a> <br/>
                <strong>Phone:</strong> +1 (123) 456-7890 <br/>
                <strong>Address:</strong> 123 Example Street, Example City, EX 12345
            </p>
            <strong>- Note that it's just an example and no real contact information.</strong>

            <h2>Contact Form</h2>
            <form
                onSubmit={(e) => {
                    e.preventDefault();
                    alert('Thank you for contacting! Note that this is just an example and no real contact has been made.');
                }}
                className={styles.form}>
                <label>
                    Name:
                    <input
                        type="text"
                        name="name"
                        placeholder="Enter your name"
                        required
                    />
                </label>
                <label>
                    Email:
                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    />
                </label>
                <label>
                    Message:
                    <textarea
                        name="message"
                        placeholder="Write your message here..."
                        rows="5"
                        required
                    />
                </label>
                <button>
                    Send Message
                </button>
                <strong className={styles['form-note']}>
                    - Note that it's just an example and no real contact form.
                </strong>
            </form>
        </div>
    );
};

export default ContactPage;