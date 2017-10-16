SELECT
    results.months,
    results.cohort,
    results.actives / user_totals.total * 100 AS percent_active
FROM
    (
        SELECT
            ROUND(DATEDIFF(audits.created, users.created) / 30.4) AS months,
            DATE_FORMAT(audits.created, '%Y/%m')                  AS month,
            DATE_FORMAT(users.created, '%Y/%m')                   AS cohort,
            COUNT(DISTINCT users.id)                              AS actives
        FROM users
            JOIN audits ON
                            audits.source_key = users.id AND
                            audits.source = 'users'
        GROUP BY cohort, months
    ) AS results
    JOIN
    (
        SELECT
            DATE_FORMAT(users.created, "%Y/%m") AS cohort,
            count(users.id)                     AS total
        FROM users
        GROUP BY cohort
    ) AS user_totals ON user_totals.cohort = results.cohort
WHERE results.month < DATE_FORMAT(NOW(), '%Y/%m')
ORDER BY months, cohort;
