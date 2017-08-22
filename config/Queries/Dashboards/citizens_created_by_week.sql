SELECT
    DATE_FORMAT(created, '%Y-W%u') AS period,
    COUNT(*) as count
FROM users
WHERE
    role = 'citizen' AND
	created IS NOT NULL
GROUP BY
    YEARWEEK(created)
ORDER BY
	created DESC
LIMIT 10
