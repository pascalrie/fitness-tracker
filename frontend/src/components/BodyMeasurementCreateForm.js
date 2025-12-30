import {useState} from "react";
import axios from "axios";
import "../styles/BodyMeasurementCreateForm.css";

const BodyMeasurementCreateForm = () => {
    const [fitnessEvaluation, setFitnessEvaluation] = useState(0);
    const [bodyWeight, setBodyWeight] = useState(0.0);
    const [bodyHeight, setBodyHeight] = useState(0.0);
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        try {
            const bodyMeasurementData = {
                fitnessEvaluation: fitnessEvaluation,
                bodyWeight: bodyWeight,
                bodyHeight: bodyHeight
            };

            await axios.post("https://backend-fitness-tracker-v5.ddev.site/api/body/measurement/create", bodyMeasurementData);
            alert("Body measurement created successfully");
        } catch(error) {
            console.error("Error creating Body measurement: ", error);
            alert("Failed to create Body measurement. Please try again.");
        } finally {
            setIsSubmitting(false);
        }
    }

    return (
        <form onSubmit={handleSubmit} className="form-container">
            <h2>Create New Body Measurement</h2>
            <div className="form-group">
                <label htmlFor="title" className="label">Fitness evaluation:</label>
                <input
                    type="number"
                    id="fitnessEvaluation"
                    name="fitnessEvaluation"
                    value={fitnessEvaluation}
                    onChange={(e) => setFitnessEvaluation(parseInt(e.target.value))}
                    placeholder="set fitness evaluation"
                    className="input"
                />
            </div>
            <div className="form-group">
                <label htmlFor="title" className="label">Body weight: (in kg)</label>
                <input
                    type="number"
                    id="bodyWeight"
                    name="bodyWeight"
                    value={bodyWeight}
                    onChange={(e) => setBodyWeight(parseFloat(e.target.value))}
                    placeholder="set body weight"
                    className="input"
                />
            </div>

            <div className="form-group">
                <label htmlFor="title" className="label">Body height: (in m with "," seperator) </label>
                <input
                    type="number"
                    id="bodyHeight"
                    name="bdoyHeight"
                    value={bodyHeight}
                    onChange={(e) => setBodyHeight(parseFloat(e.target.value))}
                    placeholder="set body height"
                    className="input"
                />
            </div>
            <button
                type="submit"
                disabled={isSubmitting}
                className={`button ${isSubmitting ? 'disabled' : 'enabled'}`}
            >
                {isSubmitting ? "Creating..." : "Create Body Measurement"}
            </button>
        </form>
    );
};

export default BodyMeasurementCreateForm;