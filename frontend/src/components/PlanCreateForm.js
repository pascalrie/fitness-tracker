import {useState} from "react";
import axios from "axios";
import "../styles/PlanCreateForm.css";

const PlanCreateForm = () => {
    const [totalDaysOfTraining, setTotalDaysOfTraining] = useState(0);
    const [trainingTimesAWeek, setTrainingTimesAWeek] = useState(0);
    const [split, setSplit] = useState(0);
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        try {
            const planData = {
                totalDaysOfTraining: totalDaysOfTraining,
                trainingTimesAWeek: trainingTimesAWeek,
                split: split
            };

            await axios.post("https://backend-fitness-tracker-v5.ddev.site/api/plan/create", planData);
            alert("Plan created successfully");
        } catch(error) {
            console.error("Error creating plan: ", error);
            alert("Failed to create plan. Please try again.");
        } finally {
            setIsSubmitting(false);
        }
    }

    return (
        <form onSubmit={handleSubmit} className="form-container">
            <h2>Create New Plan</h2>
            <div className="form-group">
                <label htmlFor="title" className="label">Total Days of Training:</label>
                <input
                    type="number"
                    id="totalDaysOfTraining"
                    name="totalDaysOfTraining"
                    value={totalDaysOfTraining}
                    onChange={(e) => setTotalDaysOfTraining(parseInt(e.target.value))}
                    placeholder="set total days of training"
                    className="input"
                />
            </div>
            <div className="form-group">
                <label htmlFor="title" className="label">Training Times a Week: </label>
                <input
                    type="number"
                    id="trainingTimesAWeek"
                    name="trainingTimesAWeek"
                    value={trainingTimesAWeek}
                    onChange={(e) => setTrainingTimesAWeek(parseInt(e.target.value))}
                    placeholder="set training times a week"
                    className="input"
                />
            </div>

            <div className="form-group">
                <label htmlFor="title" className="label">Split: </label>
                <input
                    type="number"
                    id="split"
                    name="split"
                    value={split}
                    onChange={(e) => setSplit(parseInt(e.target.value))}
                    placeholder="set split"
                    className="input"
                />
            </div>
            <button
                type="submit"
                disabled={isSubmitting}
                className={`button ${isSubmitting ? 'disabled' : 'enabled'}`}
            >
                {isSubmitting ? "Creating..." : "Create Plan"}
            </button>
        </form>
    );
};

export default PlanCreateForm;