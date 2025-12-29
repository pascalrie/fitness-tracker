import {useEffect, useState} from "react";
import axios from "axios";
import {useNavigate} from "react-router-dom";

const ExerciseListForm = () => {
    const [exercises, setExercises] = useState([]);

    let navigate = useNavigate();
    const routeChange = () => {
        let path = "/create/exercise";
        navigate(path);
    }
    useEffect(() => {
        const fetchExercises = async () => {
            try {
                const response = await axios.get("https://backend-fitness-tracker-v5.ddev.site/api/exercise/list");
                const data = response.data;
                if (Array.isArray(data)) {
                    setExercises(data);
                } else if (typeof data === "object") {
                    const exercisesArray = Object.values(data).filter((exercises) => typeof exercises === "object");
                    setExercises(exercisesArray);
                } else {
                    console.error("Unexpected data format for exercise.", data);
                }
            } catch (error) {
                console.error("Error fetching Exercises: ", error);
                setExercises([]);
            }
        }
        fetchExercises();
    }, []);
    return (
        <div className="p-4">
            <h2 className="text-xl font-bold mb-4">My Exercises</h2>
            {exercises.length === 0 ? (
                <p>No Exercises found.</p>
            ) : (
                <ul className="space-y-3">
                    {exercises.map((exercise) => (
                        <li
                            key={exercise.id}
                            className="border rounded-xl p-3 shadow-sm hover:bg-gray-50"
                        >
                            <h3 className="font-semibold">{exercise.startDate}</h3>
                            <p>id: {exercise.id}</p>
                            <p>uniqueName: {exercise.uniqueName}</p>
                        </li>
                    ))}
                </ul>
            )}
            <button color="primary" className="px-4" onClick={routeChange}>Create Exercise</button>
        </div>
    );
}

export default ExerciseListForm;