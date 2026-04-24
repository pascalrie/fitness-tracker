import {useEffect, useState} from "react";
import {useNavigate} from "react-router-dom";
import axios from "axios";

const WorkoutListForm = () => {
    const [workouts, setWorkouts] = useState([]);

    let navigate = useNavigate();
    const routeChange = () => {
        let path = "/create/workout";
        navigate(path);
    }

    useEffect(() => {
        const fetchWorkouts = async () => {
            try {
                const response = await axios.get("https://backend-fitness-tracker-v5.ddev.site/api/workout/list");
                const data = response.data;
                if (Array.isArray(data)) {
                    setWorkouts(data);
                } else if (typeof data === "object") {
                    const workoutArray = Object.values(data).filter((workouts) => typeof workouts === "object");
                    setWorkouts(workoutArray);
                } else {
                    console.error("Unexpected data format for workouts.", data);
                }
            } catch (error) {
                console.error("Error fetching Workouts: ", error);
                setWorkouts([]);
            }
        }
        fetchWorkouts([]);
    }, []);
    return (
        <div className="p-4">
            <h2 className="text-xl font-bold mb-4">My Workouts</h2>
            {workouts.length === 0 ? (
                <p>No workouts found.</p>
            ) : (
                <ul className="space-y-3">
                    {workouts.map((workout) => (
                        <li
                            key={workout.id}
                            className="border rounded-xl p-3 shadow-sm hover:bg-gray-50"
                        >
                            <h3 className="font-semibold">{workout.dateOfWorkout}</h3>
                            <p>Date of Workout: {workout.dateOfWorkout}</p>
                            <p>Stretch: {workout.stretch.toString()}</p>
                            <p>Body Weight: {workout.bodyWeight.toString()} kg</p>
                        </li>
                    ))}
                </ul>
            )}
            <button color="primary" className="px-4" onClick={routeChange}>Create Workout</button>
        </div>
    );
}

export default WorkoutListForm;