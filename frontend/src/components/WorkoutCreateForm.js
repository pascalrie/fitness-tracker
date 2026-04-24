import {useEffect, useState} from "react";
import axios from "axios";
import {useNavigate} from "react-router-dom";
import WorkoutListLatest from "./WorkoutListLatest";

const WorkoutCreateForm = () => {
    const [hasStretched, setHasStretched] = useState(false);
    const [bodyWeight, setBodyWeight] = useState(0.0);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [isList, setIsList] = useState(false);
    const [latestWorkout, setLatestWorkout] = useState(null);

    let navigate = useNavigate();

    const routeChange = () => {
        let path = "/workouts";
        setIsList(true);
        navigate(path);
    }

    useEffect(() => {
        const fetchLatestWorkout = async () => {
            try {
                const response = await axios.get("https://backend-fitness-tracker-v5.ddev.site/api/workout/latest");
                const data = response.data;
                if (typeof data === "object") {
                    setLatestWorkout(data);
                } else {
                    console.error("Unexpected data format for latest workout.", data);
                }
            } catch (error) {
                console.error("Error fetching latest workout: ", error);
                setLatestWorkout(null);
            }
        }
        fetchLatestWorkout();
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        if (!isList) {
            try {
                const workoutData = {
                    stretch: hasStretched,
                    bodyWeight: bodyWeight
                };

                await axios.post("https://backend-fitness-tracker-v5.ddev.site/api/workout/create", workoutData);
                alert("Workout created successfully");
            } catch (error) {
                console.error("Error creating workout: ", error);
                alert("Failed to create workout. Please try again.");
            } finally {
                setIsSubmitting(false);
            }
        }
    }


    return (
        <form onSubmit={handleSubmit} className="form-container">
            <h2>Create new Workout</h2>
            <div className="form-group">
                <label htmlFor="stretch" className="label">Stretched?</label>
                <input
                    type="checkbox"
                    onChange={(e) => setHasStretched(e.target.value)}
                />
            </div>
            <div className="form-group">
                <label htmlFor="bodyWeight" className="label">Body weight in kg: </label>
                <input
                    type="number"
                    id="bodyWeight"
                    name="bodyWeight"
                    value={bodyWeight}
                    onChange={(e) => setBodyWeight(parseInt(e.target.value))}
                    placeholder="set body weight"
                    className="input"
                />
            </div>
            <button
                type="submit"
                disabled={isSubmitting}
                className={`button ${isSubmitting ? 'disabled' : 'enabled'}`}
            >
                {isSubmitting ? "Creating..." : "Create Workout"}
            </button>

            <button color="primary" className="px-4" onClick={routeChange} typeof="button">List all</button>
            {latestWorkout === null ? "Loading..." : <WorkoutListLatest workout={latestWorkout}></WorkoutListLatest>}
        </form>
    )
}

export default WorkoutCreateForm;