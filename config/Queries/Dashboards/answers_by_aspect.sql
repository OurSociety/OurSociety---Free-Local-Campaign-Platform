SELECT
    c.name,
    count(*) AS count
FROM answers AS a
    LEFT JOIN questions AS q
        ON q.id = a.question_id
    LEFT JOIN categories AS c
        ON c.id = q.category_id
GROUP BY c.name
