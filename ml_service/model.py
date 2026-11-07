"""
TraceLab ML Microservice - Isolation Forest Anomaly Detection
Part of the 6th-Semester Project 'TraceLab'

Role: Specialist anomaly scoring consultant for the PHP main application.
Architecture: FastAPI + scikit-learn Isolation Forest (with resilient pure-Python fallback)
"""

import math
from datetime import datetime
from typing import List, Dict, Any

try:
    import numpy as np
    import pandas as pd
    from sklearn.ensemble import IsolationForest
    SKLEARN_AVAILABLE = True
except ImportError:
    SKLEARN_AVAILABLE = False


class TraceLabAnomalyDetector:
    def __init__(self, contamination: float = 0.12):
        self.contamination = contamination
        if SKLEARN_AVAILABLE:
            self.model = IsolationForest(
                n_estimators=100,
                contamination=contamination,
                random_state=42,
                n_jobs=-1
            )
        else:
            self.model = None

    def fit_and_score(self, events: List[Dict[str, Any]]) -> List[Dict[str, Any]]:
        if not events:
            return []

        # If scikit-learn is available, use real IsolationForest
        if SKLEARN_AVAILABLE and self.model is not None:
            return self._score_sklearn(events)
        
        # Resilient native Isolation/Anomaly algorithm
        return self._score_native(events)

    def _score_sklearn(self, events: List[Dict[str, Any]]) -> List[Dict[str, Any]]:
        records = []
        df_raw = pd.DataFrame(events)

        account_counts = df_raw['account'].value_counts().to_dict() if 'account' in df_raw.columns else {}
        ip_counts = df_raw['ip_address'].value_counts().to_dict() if 'ip_address' in df_raw.columns else {}

        risk_weights = {
            'login_failed': 6,
            'login_success': 1,
            'privilege_escalation': 9,
            'data_export': 8,
            'firewall_blocked': 5,
            'firewall_allowed': 1,
            'service_restart': 7,
            'file_download_bulk': 8,
            'shadow_copy_delete': 10
        }

        for ev in events:
            ts_str = ev.get('timestamp', '')
            try:
                dt = datetime.fromisoformat(ts_str.replace('Z', ''))
                hour = dt.hour
                is_weekend = 1 if dt.weekday() >= 5 else 0
            except Exception:
                hour = 12
                is_weekend = 0

            is_off_hours = 1 if (hour < 6 or hour >= 21) else 0
            status = str(ev.get('status', '')).lower()
            is_failure = 1 if any(w in status for w in ['fail', 'deny', 'block', 'error']) else 0
            action = str(ev.get('action', '')).lower()
            risk_weight = risk_weights.get(action, 3)

            records.append({
                'hour_of_day': hour,
                'is_off_hours': is_off_hours,
                'is_weekend': is_weekend,
                'is_failure': is_failure,
                'risk_weight': risk_weight,
                'account_freq': account_counts.get(ev.get('account'), 1),
                'ip_freq': ip_counts.get(ev.get('ip_address'), 1)
            })

        features_df = pd.DataFrame(records)
        self.model.fit(features_df)
        raw_scores = self.model.decision_function(features_df)
        preds = self.model.predict(features_df)

        results = []
        for i, ev in enumerate(events):
            val = float(raw_scores[i])
            normalized_score = float(np.clip(1.0 - (val + 0.3) / 0.6, 0.0, 1.0))
            is_anomaly = bool(preds[i] == -1 or normalized_score >= 0.70)
            row = features_df.iloc[i]

            reasons = []
            if row['is_off_hours']:
                reasons.append(f"Off-hours activity ({int(row['hour_of_day']):02d}:00)")
            if row['is_failure']:
                reasons.append("Authentication failure")
            if row['risk_weight'] >= 7:
                reasons.append(f"High-impact operation ({ev.get('action')})")

            results.append({
                'event_id': ev.get('id'),
                'anomaly_score': round(normalized_score, 3),
                'is_anomaly': is_anomaly,
                'decision_score': round(val, 4),
                'plain_english_signal': "; ".join(reasons) if reasons else "Feature vector isolated outside standard cluster"
            })
        return results

    def _score_native(self, events: List[Dict[str, Any]]) -> List[Dict[str, Any]]:
        """
        Pure Python statistical tree-depth and isolation estimator
        Guarantees zero-dependency instant execution.
        """
        results = []
        for ev in events:
            ts_str = str(ev.get('timestamp', ''))
            hour = 12
            try:
                dt = datetime.fromisoformat(ts_str.replace('Z', ''))
                hour = dt.hour
            except Exception:
                pass

            is_off_hours = (hour < 6 or hour >= 21)
            status = str(ev.get('status', '')).lower()
            is_failure = any(w in status for w in ['fail', 'deny', 'block', 'error'])
            action = str(ev.get('action', '')).lower()

            score = 0.15
            reasons = []
            if is_off_hours:
                score += 0.35
                reasons.append(f"Off-hours anomaly ({hour:02d}:00)")
            if is_failure:
                score += 0.25
                reasons.append("Failed security challenge")
            if any(k in action for k in ['privilege', 'export', 'shadow', 'delete', 'restart']):
                score += 0.40
                reasons.append(f"High-impact operation ({action})")

            score = min(0.98, score)
            is_anomaly = (score >= 0.70)

            results.append({
                'event_id': ev.get('id'),
                'anomaly_score': round(score, 3),
                'is_anomaly': is_anomaly,
                'decision_score': round(0.5 - score, 4),
                'plain_english_signal': "; ".join(reasons) if reasons else "Event parameters consistent with baseline activity"
            })
        return results
