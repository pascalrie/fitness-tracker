import React from 'react';

const AboutPage = () => {
    return (
        <div style={{ padding: '20px', fontFamily: 'Arial, sans-serif', lineHeight: '1.6' }}>
            <h1>About</h1>
            <p>
                Welcome to the Fitness Tracker V5 application! The vision of the creator is to create a platform that
                allows users to capture their progress in fitness in a simple and intuitive way.
            </p>
            <h2>Who I am</h2>
            <p>
                I am a passionate developer and thinker dedicated to building tools that inspire creativity
                and productivity.
            </p>
            <h2>What I do</h2>
            <p>
                The platform is designed to:
            </p>
            <ul>
                <li>Help you create and organize Fitness plans effortlessly. </li>
                <li>You can setup muscle groups, workouts and plans for your gym-day.</li>
                <li>It lets you track execution units of your plan with repetitions, weight and an exercise.</li>
            </ul>
            <h2>Contact Us</h2>
            <p>
                Have questions or feedback? We'd love to hear from you!
                Reach out to us at <a href="mailto:example@example.example">example@example.example</a><br/>.
                <strong>- Note that it's just an example and no real contact information.</strong>
            </p>
        </div>
    );
};

export default AboutPage;