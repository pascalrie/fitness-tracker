import React from "react";

/**
 * RenderValue
 * - rendert primitive Werte (string, number, boolean, null)
 * - erkennt Datum-Strings im Format YYYY-MM-DD HH:MM:SS und formatiert sie
 */
const RenderValue = ({ value }) => {
    if (value === null) return <em>null</em>;
    if (typeof value === "boolean") return <span>{value ? "true" : "false"}</span>;
    if (typeof value === "number") return <span>{value}</span>;
    if (typeof value === "string") {
        // einfacher DateTime-Detektor (anpassbar)
        const dateLike = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/.test(value)
            ? new Date(value.replace(" ", "T"))
            : null;
        if (dateLike && !isNaN(dateLike)) return <time>{dateLike.toLocaleString()}</time>;
        return <span>{value}</span>;
    }
    return <span>{String(value)}</span>;
};

/**
 * RenderObject
 * - rekursiv: behandelt Arrays, plain objects und fallback
 */
const RenderObject = ({ data, depth = 0 }) => {
    const indentStyle = { marginLeft: depth * 12 };

    if (Array.isArray(data)) {
        if (data.length === 0) return <div style={indentStyle}><em>Leeres Array</em></div>;
        return (
            <ul style={indentStyle}>
                {data.map((item, i) => (
                    <li key={i} style={{ marginBottom: 6 }}>
                        <RenderObject data={item} depth={depth + 1} />
                    </li>
                ))}
            </ul>
        );
    }

    if (typeof data === "object" && data !== null) {
        const entries = Object.entries(data);
        if (entries.length === 0) return <div style={indentStyle}><em>Leeres Objekt</em></div>;

        return (
            <div style={{ ...indentStyle, borderLeft: "2px solid #eee", paddingLeft: 8 }}>
                {entries.map(([key, value]) => (
                    <div key={key} style={{ marginBottom: 6 }}>
                        <strong style={{ display: "inline-block", width: 160 }}>{key}:</strong>
                        {typeof value === "object" && value !== null ? (
                            <RenderObject data={value} depth={depth + 1} />
                        ) : (
                            <span style={{ marginLeft: 8 }}><RenderValue value={value} /></span>
                        )}
                    </div>
                ))}
            </div>
        );
    }

    // primitive
    return (
        <div style={indentStyle}>
            <RenderValue value={data} />
        </div>
    );
};

/**
 * NestedJsonViewer
 * Props:
 * - data: das JSON-Objekt oder Array vom Backend
 * - title: optionaler Titel
 */
export const NestedJsonViewer = ({ data, title }) => {
    if (data === undefined) return null;
    if (data === null) return <div><em>null</em></div>;

    return (
        <div style={{ fontFamily: "Inter, Roboto, sans-serif", lineHeight: 1.4 }}>
            {title && <h3 style={{ marginBottom: 8 }}>{title}</h3>}
            <RenderObject data={data} />
        </div>
    );
};

export default NestedJsonViewer;