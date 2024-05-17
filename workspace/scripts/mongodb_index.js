db.title_basics.createIndex({ primaryTitle: "text" });
db.title_basics.createIndex({
    primaryTitle: "text",
    originalTitle: "text",
    genres: "text"
    // Add additional fields if necessary
});
