import {useState} from "react";
import axios from "axios";

const ExerciseCreateForm = () => {
    const [uniqueName, setUniqueName] = useState("");
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        try {
            const exerciseData = {
                uniqueName: uniqueName
            }
            await axios.post("https://backend-fitness-tracker-v5.ddev.site/api/exercise/create", exerciseData);
            alert("Exercise created successfully");
        } catch (error) {
            console.error("Error creating exercise: ", error);
            alert("Failed to create exercise. Please try again.");
        } finally {
            setIsSubmitting(false)
        }
    }

    return (
        <form onSubmit={handleSubmit} className="form-container">
            <h2>Create new Exercise</h2>
            <div className="form-group">
                <label htmlFor="title" className="label">Unique Name: </label>
                <input
                    type="text"
                    id="uniqueName"
                    name="uniqueName"
                    value={uniqueName}
                    onChange={(e) => setUniqueName(e.target.value)}
                    placeholder="set unique name"
                    className="input"
                />
            </div>
            <button
                type="submit"
                disabled={isSubmitting}
                className={`button ${isSubmitting ? 'disabled' : 'enabled'}`}
            >
                {isSubmitting ? "Creating..." : "Create Exercise"}
            </button>
        </form>
    );
};

export default ExerciseCreateForm;