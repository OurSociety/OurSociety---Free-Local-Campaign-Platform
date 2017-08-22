SELECT
    DATE_FORMAT(last_seen, '%Y-W%u') AS period,
    COUNT(*) as count
FROM users
WHERE
    role = 'politician' AND
	last_seen IS NOT NULL
GROUP BY
    YEARWEEK(last_seen)
ORDER BY
	last_seen DESC
LIMIT 10
