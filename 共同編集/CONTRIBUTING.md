# 共同編集ガイドライン

このプロジェクトに貢献していただき、ありがとうございます！以下のガイドラインに従って、効率的な共同編集を行いましょう。

## 開発環境のセットアップ

1. **リポジトリのフォーク**
   - GitHubでこのリポジトリをフォーク
   - 自分のアカウントにコピーを作成

2. **ローカルにクローン**
```bash
git clone https://github.com/[あなたのユーザー名]/[リポジトリ名].git
cd ぷろN\ /共同編集
```

3. **上流リポジトリを追加**
```bash
git remote add upstream https://github.com/[元のユーザー名]/[リポジトリ名].git
```

## ブランチ戦略

- `main`: 本番環境用の安定版
- `develop`: 開発用ブランチ
- `feature/機能名`: 新機能開発用
- `bugfix/バグ名`: バグ修正用

### ブランチの作成例
```bash
# 新機能開発の場合
git checkout -b feature/task-priority develop

# バグ修正の場合
git checkout -b bugfix/gantt-chart-display develop
```

## コミットメッセージ規約

明確で一貫したコミットメッセージを使用してください：

```
[type]: [簡潔な説明]

[詳細な説明（必要に応じて）]
```

### Type一覧
- `feat`: 新機能
- `fix`: バグ修正
- `docs`: ドキュメント更新
- `style`: コードフォーマット（機能に影響なし）
- `refactor`: リファクタリング
- `test`: テスト追加・修正
- `chore`: ビルドやツール関連

### 例
```bash
git commit -m "feat: タスク優先度機能を追加"
git commit -m "fix: ガントチャートの日付表示バグを修正"
git commit -m "docs: READMEに使用方法を追加"
```

## プルリクエスト（PR）

1. **最新の変更を取得**
```bash
git fetch upstream
git checkout develop
git merge upstream/develop
```

2. **自分のブランチを更新**
```bash
git checkout feature/your-feature
git rebase develop
```

3. **変更をプッシュ**
```bash
git push origin feature/your-feature
```

4. **PRを作成**
   - GitHubでPRを作成
   - 明確なタイトルと説明を記入
   - レビュアーを指定

## コーディング規約

### JavaScript
- ES6+を使用
- `const`/`let`を使用（`var`は避ける）
- 関数名、変数名は日本語または英語で意味のあるものを使用
- コメントは日本語で記述

```javascript
// Good
const taskList = [];
const addNewTask = (taskName) => {
    // タスクを追加する処理
};

// Bad
var a = [];
function add(x) {
    // 処理
}
```

### CSS
- BEMに準拠したクラス名（可能な限り）
- レスポンシブデザインを考慮
- 色は変数で管理

### HTML
- セマンティックなタグを使用
- アクセシビリティを考慮

## ファイル構成のルール

- **index.html**: メインのHTMLファイル（大きな変更時は事前相談）
- **script.js**: JavaScript機能（機能ごとに関数を分割）
- **style.css**: スタイルシート（セクションごとにコメントで区切り）

## テスト

現在テストフレームワークは導入されていませんが、以下を手動で確認：

1. **基本機能テスト**
   - タスクの追加・編集・削除
   - ガントチャートの表示
   - データの保存・読み込み

2. **ブラウザ互換性**
   - Chrome, Firefox, Safari, Edgeで動作確認

3. **レスポンシブデザイン**
   - モバイル、タブレット、デスクトップでの表示確認

## 課題の報告

バグや機能要求は、GitHubのIssuesで報告してください：

### バグ報告テンプレート
```
**バグの概要**
何が起こったか

**再現手順**
1. ...
2. ...
3. ...

**期待される動作**
何が起こるべきか

**環境**
- OS: 
- ブラウザ: 
- バージョン: 
```

## コミュニケーション

- **質問**: GitHubのDiscussionsまたはIssues
- **アイデア**: Issues with "enhancement" label
- **緊急度の高いバグ**: Issues with "bug" and "urgent" labels

## リリースプロセス

1. `develop`ブランチで機能開発・テスト
2. `main`ブランチにマージ
3. タグを作成してリリース

---

ご質問やご提案がございましたら、お気軽にIssuesでお知らせください！