import {useEffect, useState} from "react";
import axios from "axios";
import NestedJsonViewer from "./RenderObjectsOrArrays";
import {useNavigate} from "react-router-dom";

const ExecutionListForm = () => {
    const [executions, setExecutions] = useState([]);
    const [payload, setPayload] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    let navigate = useNavigate();
    const routeChange = () => {
        let path = "/create/execution";
        navigate(path);
    }

    useEffect(() => {
        const fetchExecutions = async() => {
            try {
                const response = await axios.get("https://backend-fitness-tracker-v5.ddev.site/api/execution/list");
                const data = response.data;
                setPayload(data.executions)
                if (Array.isArray(data)) {
                    setExecutions(data);
                } else if (typeof data === "object") {
                    const executionsArray = Object.values(data).filter((executions) => typeof executions === "object");
                    setExecutions(executionsArray);
                } else {
                    console.error("Unexpected data format for executions.", data);
                }
            } catch (error) {
                console.error("Error fetching Executions: ", error);
                setExecutions([]);
            }
        }
        fetchExecutions();
    }, []);
    return (
        <div className="p-4">
            <h2 className="text-xl font-bold mb-4">My Executions</h2>
            {executions.length === 0 ? (
                <p>No executions found.</p>
            ) : (
                <ul className="space-y-3">
                    {executions.map((execution) => (
                        <li
                            key={execution.id}
                            className="border rounded-xl p-3 shadow-sm hover:bg-gray-50"
                        >
                            <h3 className="font-semibold">{execution.createdAt}</h3>
                            <div>
                                <NestedJsonViewer data={payload} title="Exercise" />
                            </div>
                            <p>Exercise: {execution.exercise.uniqueName}</p>
                            <p>Repetitions: {execution.repetitions}</p>
                            <p>Weight: {execution.weight} kg</p>
                            <p>Workout-id: {execution.workout.id}</p>
                        </li>
                    ))}
                </ul>
            )}
            <button color="primary" className="px-4" onClick={routeChange}>Create Execution</button>
        </div>
    );
}

export default ExecutionListForm;