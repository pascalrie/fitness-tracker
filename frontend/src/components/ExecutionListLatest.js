import {useEffect, useState} from "react";
import axios from "axios";

const ExecutionListLatest = (executions) => {
    const reversedExecutions = [...executions.executions].reverse().slice(0, 5);
    return (
        <div>
        <h2>My latest Executions</h2>
        {reversedExecutions.length === 0 ? (
            <p>No executions found.</p>
        ) : (
            <ul className="space-y-3">
                {reversedExecutions.map((execution) => (
                    <li
                        key={execution.id}
                    >
                        <h3>{execution.createdAt}: {execution.exercise.uniqueName},
                            {execution.repetitions}x {execution.weight} kg </h3>
                    </li>
                ))}
            </ul>
        )}
    </div>
    );
}
export default ExecutionListLatest;