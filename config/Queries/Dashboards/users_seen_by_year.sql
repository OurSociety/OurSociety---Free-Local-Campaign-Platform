SELECT
    DATE_FORMAT(last_seen, '%Y') AS period,
    COUNT(*) as count
FROM users
WHERE
	last_seen IS NOT NULL
GROUP BY
	YEAR(last_seen)
ORDER BY
	last_seen DESC
LIMIT 10
