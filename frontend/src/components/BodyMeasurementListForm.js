import {useEffect, useState} from "react";
import axios from "axios";
import {useNavigate} from "react-router-dom";

const BodyMeasurementListForm = () => {
    const [bodyMeasurements, setBodyMeasurements] = useState([]);


    let navigate = useNavigate();
    const routeChange = () => {
        let path = "/create/body/measurement";
        navigate(path);
    }
    useEffect(() => {
        const fetchBodyMeasurements = async () => {
            try {
                const response = await axios.get("https://backend-fitness-tracker-v5.ddev.site/api/body/measurement/list");
                const data = response.data;
                if (Array.isArray(data)) {
                    setBodyMeasurements(data);
                } else if (typeof data === "object") {
                    const bodyMeasurementsArray = Object.values(data).filter((bodyMeasurements) => typeof bodyMeasurements === "object");
                    setBodyMeasurements(bodyMeasurementsArray);
                } else {
                    console.error("Unexpected data format for body measurement.", data);
                }
            } catch (error) {
                console.error("Error fetching Body measurements: ", error);
                setBodyMeasurements([]);
            }
        }
        fetchBodyMeasurements();
    }, []);
    return (
        <div className="p-4">
            <h2 className="text-xl font-bold mb-4">My Body Measurements</h2>
            {bodyMeasurements.length === 0 ? (
                <p>No Body Measurements found.</p>
            ) : (
                <ul className="space-y-3">
                    {bodyMeasurements.map((bodyMeasurement) => (
                        <li
                            key={bodyMeasurement.id}
                            className="border rounded-xl p-3 shadow-sm hover:bg-gray-50"
                        >
                            <h3 className="font-semibold">{bodyMeasurement.createdAt}</h3>
                            <p>id: {bodyMeasurement.id}</p>
                            <p>Created at: {bodyMeasurement.createdAt.toString()}</p>
                            <p>Updated at: {bodyMeasurement.updatedAt.toString()}</p>
                            <p>Body weight: {bodyMeasurement.bodyWeight.toString()} kg </p>
                            <p>Bmi: {bodyMeasurement.bmi.toString()}</p>
                            <p>Fitness evaluation: {bodyMeasurement.fitnessEvaluation.toString()}</p>
                            <p>Body height: {bodyMeasurement.bodyHeight.toString()} m </p>
                        </li>
                    ))}
                </ul>
            )}
            <button color="primary" className="px-4" onClick={routeChange}>Create Body Measurement</button>
        </div>
    );
}

export default BodyMeasurementListForm;