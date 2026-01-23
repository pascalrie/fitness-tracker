import {useEffect, useState} from "react";
import axios from "axios";
import "../styles/ExecutionCreateForm.css";
import {useNavigate} from "react-router-dom";
import WorkoutListLatest from "./WorkoutListLatest";

const ExecutionCreateForm = () => {
        const [repetitions, setRepetitions] = useState(12);
        const [weight, setWeight] = useState(0);
        const [isSubmitting, setIsSubmitting] = useState(false);

        const [exercises, setExercises] = useState([]);
        const [selectedExercise, setSelectedExercise] = useState(null);

        const [isList, setIsList] = useState(false);

        const [workout, setLatestWorkout] = useState(null);

        let navigate = useNavigate();

        const routeChange = () => {
            let path = "/executions";
            setIsList(true);
            navigate(path);
        }

        useEffect(() => {
            const fetchExerciseNames = async () => {
                try {
                    const response = await axios.get("https://backend-fitness-tracker-v5.ddev.site/api/exercise/list");
                    const data = response.data;
                    if (Array.isArray(data)) {
                        setExercises(data);
                    } else if (typeof data === "object") {
                        const exerciseArray = Object.values(data).filter((exercise) => typeof exercise === "object");
                        setExercises(exerciseArray);
                    } else {
                        console.error("Unexpected data format for exercise ids.", data);
                    }
                } catch (error) {
                    console.error("Error fetching exerciseIds: ", error);
                    setExercises([]);
                }
            }
            fetchExerciseNames();

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
            if (!selectedExercise && !isList) {
                alert("Exercise name selection is required. ");
                return;
            }

            setIsSubmitting(true);
            if (!isList) {
                try {
                    const executionData = {
                        exerciseName: selectedExercise.uniqueName,
                        repetitions: repetitions,
                        weight: weight
                    };

                    await axios.post("https://backend-fitness-tracker-v5.ddev.site/api/execution/create", executionData);
                    alert("Execution created successfully");
                    setSelectedExercise("");
                } catch (error) {
                    console.error("Error creating execution: ", error);
                    alert("Failed to create execution. Please try again.");
                } finally {
                    setIsSubmitting(false);
                }
            }
        }

        return (
            <form onSubmit={handleSubmit} className="form-container">
                <h2>Create New Execution</h2>
                <div className="form-group">
                    <label htmlFor="exerciseName" className="label">Exercise:</label>
                    <select
                        id="exercise"
                        name="exercise"
                        value={selectedExercise ? selectedExercise.id : ""}
                        onChange={(e) => {
                            const selected = exercises.find((exercise) => exercise.id === parseInt(e.target.value));
                            console.log(selected);
                            setSelectedExercise(selected || null);
                        }}
                        className="select"
                    >
                        <option value="" disabled={false}>
                            Select an exercise
                        </option>
                        {exercises.map((exercise) => (
                            <option key={exercise.id} value={exercise.id}>
                                {exercise.id} {exercise.uniqueName}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="form-group">
                    <label htmlFor="title" className="label">Repetitions:</label>
                    <input
                        type="number"
                        id="repetitions"
                        name="repetitions"
                        value={repetitions}
                        onChange={(e) => setRepetitions(parseInt(e.target.value))}
                        placeholder="set reps"
                        className="input"
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="title" className="label">Weight in kg:</label>
                    <input
                        type="number"
                        id="weight"
                        name="weight"
                        value={weight}
                        onChange={(e) => setWeight(parseInt(e.target.value))}
                        placeholder="set weight"
                        className="input"
                    />
                </div>
                <button
                    type="submit"
                    disabled={isSubmitting}
                    className={`button ${isSubmitting ? 'disabled' : 'enabled'}`}
                >
                    {isSubmitting ? "Creating..." : "Create Execution"}
                </button>
                {workout === null ? "Loading..." : <WorkoutListLatest workout={workout}></WorkoutListLatest>}
                <button color="primary" className="px-4" onClick={routeChange} typeof="button">List all</button>
            </form>
        );
    }
;
export default ExecutionCreateForm;